<template>
    <div>
        <el-input
            v-for="value of selectProduct"
            style="display: none"
            name="products[]"
            :key="value.id"
            :value="value.id"
        >
        </el-input>

        <el-select @remove-tag="handleRemove" @focus="handleClick" multiple v-model="currentSelect"
                   placeholder="请选择产品">
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
                :check-strictly=true
                :default-checked-keys="currentSelect"
                node-key="id"
                empty-text="请添加产品"
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
import {getAllProducts} from '../api/product'

export default {
    props: ['coupon'],
    data() {
        return {
            filterText: '',
            loading: false,
            dialogShowVisible: false,
            data: [],
            items: [],
            currentSelect:[],
            selectProduct:[],
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
            this.selectProduct.forEach((vv,index) => {
                if (vv.id===value){
                    this.selectProduct.splice(index,1)
                }
            })
        },
        handleClose() {
            this.currentSelect = this.$refs.tree.getCheckedKeys()
            this.selectProduct = this.$refs.tree.getCheckedNodes()
        }
    },
    mounted() {
        getAllProducts(this.coupon).then(response => {
            this.data = response.data.products
            this.currentSelect = response.data.currentSelect
            this.selectProduct = response.data.selectProduct
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
