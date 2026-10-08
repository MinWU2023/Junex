<template>
    <div>
        <el-input
            v-for="value of selectCategory"
            style="display: none"
            name="articles[]"
            :key="value.id"
            :value="value.id"
        >
        </el-input>

        <el-select @remove-tag="handleRemove" @focus="handleClick" multiple v-model="currentSelect"
               placeholder="请选择文章">
            <el-option
                v-for="value in currentSelect"
                :key="value"
                :value="value">
            </el-option>
        </el-select>
        <el-dialog @close="handleClose" v-loading="loading" title="选择文章" :visible.sync="dialogShowVisible" width="80%">
            <el-input
                style="margin-bottom: 10px;"
                size="small"
                placeholder="输入关键字进行过滤"
                v-model="filterText">
            </el-input>
            <el-tree
                :props="props"
                :data="data"
                :check-strictly=true
                :default-checked-keys="currentSelect"
                node-key="label"
                empty-text="请添加文章"
                highlight-current
                :filter-node-method="filterNode"
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
import {getAllCategories} from '../api/productArticle'

export default {
    props: ['id'],
    data() {
        return {
            filterText: '',
            loading: false,
            dialogShowVisible: false,
            data: [],
            items: [],
            currentSelect:[],
            selectCategory:[],
            props: {
                label: 'label',
                children: 'children'
            },
        }
    },
    methods: {
        handleClick() {
            this.dialogShowVisible = true
        },
        filterNode(value, data) {
            if (!value) return true;
            return data.label.indexOf(value) !== -1;
        },
        handleConfirm() {
            this.dialogShowVisible = false
            this.currentSelect = this.$refs.tree.getCheckedKeys()
        },
        handleRemove(value) {
            this.selectCategory.forEach((vv,index) => {
                if (vv.name===value){
                    this.selectCategory.splice(index,1)
                }
            })
        },
        handleClose() {
            this.currentSelect = this.$refs.tree.getCheckedKeys()
            this.selectCategory = this.$refs.tree.getCheckedNodes()
        }
    },
    mounted() {
        getAllCategories(this.id).then(response => {
            this.data = response.data.categories
            this.currentSelect = response.data.currentSelect
            this.selectCategory = response.data.selectCategory
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
