<template>
    <div class="layui-form-item" style="display: flex;align-items: center;">
<!--        <div class="item-slide" style="display: flex;flex-direction: column;">-->
<!--            <label class="layui-form-label" style="padding-bottom: 0;padding-left: 0;">Tags</label>-->
<!--            <p class="care-tips" style="color: red;display: flex;font-size: 12px;line-height: 1.5;">提示: 不要用特殊符号</p>-->
<!--        </div>-->
        <div class="layui-input-block" style="margin-left: 25px;">
            <el-input
                v-for="value of theTag"
                style="display: none"
                name="tags[]"
                :key="value"
                :value="value"
            >
            </el-input>
            <el-select
                v-model="theTag"
                size="medium"
                multiple
                filterable
                allow-create
                default-first-option
                placeholder="请选择标签">
                <el-option
                    v-for="item in tags"
                    :key="item.value"
                    :label="item.label"
                    :value="item.label">
                </el-option>
            </el-select>
        </div>
        <div    v-if="active === 1" style="margin-left: 25px;margin-top: 20px">
            <div style="margin-bottom: 15px;">
                <el-input placeholder="请输入内容" v-model="keywords" class="input-with-select">
                    <el-button slot="append" @click="search" icon="el-icon-search"></el-button>
                </el-input>
            </div>
            <el-table
                :data="tableData"
                v-loading="loading"
                height="250"
                border
                style="width: 100%">
                <el-table-column
                    label="关键词"
                    width="300"
                    filter-placement="bottom-end">
                    <template slot-scope="scope">
                        <el-tag
                            type="primary"
                            disable-transitions>{{scope.row.name}}</el-tag>
                        <el-button type="mini" plain @click="copy(scope.row.name)">添加</el-button>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="average_search_volume"
                    label="平均每月搜索量"
                    width="100">
                </el-table-column>
                <el-table-column
                    prop="average_cpc"
                    label="平均出价"
                    width="100"
                >
                </el-table-column>

                <el-table-column
                    prop="competition"
                    label="竞争度"
                    width="100"
                >
                </el-table-column>
            </el-table>
        </div>
    </div>
</template>

<style>
.input-with-select .el-input-group__prepend {
    background-color: #fff;
}
</style>

<script>
import {getAllTags,keywordsSearch} from '../api/tag'
export default {
    props: ['tag', 'type'],
    data() {
        return {
            theTag: this.tag,
            tags: [],
            loading:false,
            keywords:'',
            tableData: [],
            active:1
        }
    },
    mounted() {
        getAllTags(this.type).then(response => {
            this.tags = response.data.data
            this.active = response.data.active
        })
    },
    methods:{
        search(){
            this.loading = true
            if (this.keywords == null || this.keywords ==='' ){
                this.$message({
                    message: '请填写搜索内容',
                    type: 'error'
                });
            }else{
                keywordsSearch(this.keywords).then(response => {
                    if (response.data.error_msg){
                        this.$message({
                            message: response.data.error_msg,
                            type: 'error'
                        });
                    }else{
                        this.tableData = response.data
                    }
                })
            }
            this.loading = false
        },
        copy(value){
            //创建一个 Input标签
            for (const valueKey in this.theTag) {
                if (this.theTag[valueKey] === value){
                    return ;
                }
            }
            this.theTag.push(value)
            this.$message({
                message: '添加成功',
                type: 'success'
            });
            // let obj = {
            //     label:value,
            //     value:100,
            // }
            // this.tags[this.tags.length].push(obj)
            // let oInput = document.createElement('input');
            // oInput.value = value;
            // document.body.appendChild(oInput);
            // oInput.select(); // 选择对象;
            // // 执行浏览器复制命令
            // /// 复制命令会将当前选中的内容复制到剪切板中
            // /// 如这里构建的 Input标签
            // document.execCommand("Copy");
            // this.$message({
            //     message: '复制成功',
            //     type: 'success'
            // });
            // ///复制成功后再将构造的标签 移除
            // oInput.remove()
        },

    }
}
</script>
