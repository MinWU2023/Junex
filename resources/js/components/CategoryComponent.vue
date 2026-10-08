<template>
    <div>
        <el-input
            v-for="value of selectCategory"
            style="display: none"
            name="categories[]"
            :key="value.id"
            :value="value.id"
        >
        </el-input>

        <el-select @remove-tag="handleRemove" @focus="handleClick" multiple v-model="currentSelect"
               placeholder="请选择分类">
            <el-option
                v-for="value in currentSelect"
                :key="value"
                :value="value">
            </el-option>
        </el-select>
        <el-dialog @close="handleClose" v-loading="loading" title="选择分类" :visible.sync="dialogShowVisible" width="80%">
            <el-input
                style="margin-bottom: 10px;"
                size="small"
                placeholder="输入关键字进行过滤"
                v-model="filterText">
            </el-input>
            <el-tree
                :props="props"
                :data="data"
                :default-checked-keys="currentSelectIds"
                node-key="id"
                empty-text="请添加分类"
                highlight-current
                :filter-node-method="filterNode"
                :check-strictly="strictly"
                show-checkbox
                ref="tree"
            >
            </el-tree>
            <div slot="footer" class="dialog-footer">
                <el-button type="primary" @click="handleConfirm">确认选择</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
import {getAllCategories} from '../api/category'

export default {
    props: ['id','type'],
    data() {
        return {
            filterText: '',
            loading: false,
            dialogShowVisible: false,
            data: [],
            items: [],
            currentSelect:[],
            selectCategory:[],
            currentSelectIds:[],
            props: {
                label: 'label',
                children: 'children'
            },
            strictly:false,
        }
    },
    methods: {
        handleClick() {
            this.dialogShowVisible = true
        },
        filterNode(value, data) {
            value = value.toLowerCase();
            if (!value) return true;
            return data.label.indexOf(value) !== -1;
        },
        handleConfirm() {
            this.dialogShowVisible = false
            var arr = [];
            let select_ids = [];
            this.$refs.tree.getCheckedNodes().forEach((vv,index) => {
                select_ids.push(vv.id)
                if (!arr.includes(vv.label)){
                    arr.push(vv.label)
                }
            })
            this.currentSelectIds = select_ids;
            this.currentSelect = arr;
        },
        handleRemove(value) {
            this.selectCategory.forEach((vv,index) => {
                if (vv.name===value.toLowerCase()){
                    this.selectCategory.splice(index,1)
                }
            })
        },
        handleClose() {
            var arr = [];
            let select_ids = [];
            this.$refs.tree.getCheckedNodes().forEach((vv,index) => {
                select_ids.push(vv.id);
                if (!arr.includes(vv.label)){
                    arr.push(vv.label)
                }
            })
            this.currentSelect = arr;
            this.currentSelectIds = select_ids;
            this.selectCategory = this.$refs.tree.getCheckedNodes()
        }
    },
    mounted() {
        getAllCategories(this.id,this.type).then(response => {
            this.data = response.data.categories
            this.currentSelect = response.data.currentSelect
            this.currentSelectIds=  response.data.currentSelectIds
            this.selectCategory = response.data.selectCategory
            this.strictly = response.data.tree_strictly
        })
    },
    watch: {
        filterText(val) {
            this.$refs.tree.filter(val);
        }
    },
}
</script>

<style scoped>

</style>
