<template>
    <div v-loading="loading">
        <el-input
            name="permissions"
            style="display: none;"
            type="textarea"
            :rows="2"
            placeholder="请输入内容"
            v-model="rolePermissions.toString()">
        </el-input>
        <el-card v-for="group in guardNameByPermissions" :key="group.id" style="margin-bottom:20px;margin-left:20px;">
            <div slot="header">
                <div style="float:right">
                    <el-radio v-model="radio[group.id]" @change="change(group.id)" :label="true">全选</el-radio>
                    <el-radio v-model="radio[group.id]" @change="change(group.id)" :label="false">全不选</el-radio>
                </div>
                <span class="permission-group">{{ group.name }}</span>
            </div>
            <el-row>
                <el-checkbox-group v-model="rolePermissions">
                    <el-col
                        class="permission-item"
                        :span="6"
                        v-for="permission in group.permission"
                        :key="permission.id"><el-checkbox :label="permission.name">{{ permission.display_name}}</el-checkbox>
                    </el-col>
                </el-checkbox-group>
            </el-row>
        </el-card>
    </div>
</template>
<script>
import { getAllPemissions } from '../api/permissionGroup'
import { rolePermission } from '../api/role'
import notify from '../libs/notify'

export default {
    props: ['role_id'],
    data () {
        return {
            loading: false,
            rolePermissions: [],
            guardNameByPermissions: [],
            groupPermissions: {},
            radio: {}
        }
    },

    methods: {
        change (groupId) {
            this.groupPermissions[groupId].forEach(permission => {
                let index = this.rolePermissions.indexOf(permission)

                if (!this.radio[groupId] && index >= 0) {
                    this.rolePermissions.splice(index, 1)
                } else if (this.radio[groupId] && index === -1) {
                    this.rolePermissions.push(permission)
                }
            })
        },
        loadData () {
            this.rolePermissions = []
            this.guardNameByPermissions = []
            this.groupPermissions = {}
            this.radio = {}
            let permissionGroups = getAllPemissions()
            let rolePermissions = rolePermission(this.role_id)
            this.loading = true
            Promise.all([permissionGroups, rolePermissions]).then(result => {
                this.loading = false
                this.guardNameByPermissions = result[0].data.data

                result[0].data.data.forEach(item => {
                    if (!this.groupPermissions.hasOwnProperty(item.id)) {
                        this.groupPermissions[item.id] = []
                    }
                    item.permission.forEach(permission => {
                        this.groupPermissions[item.id].push(permission.name)
                    })
                })

                result[1].data.data.forEach(item => {
                    this.rolePermissions.push(item.name)
                })
            })
        }
    },
    created () {
        this.loadData()
    }
}
</script>
<style rel="stylesheet/scss" lang="scss" scoped>
    .permission-item {
        margin-top: 15px;
    }

    .permission-group {
        font-size: 15px;
    }
</style>
<style>
    .el-checkbox__input .layui-form-checkbox {
        display:none;
    }
</style>
