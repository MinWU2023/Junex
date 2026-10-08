<template>
    <div class="layui-form-item" style="display: flex;align-items: center;">
        <div class="item-slide" style="display: flex;flex-direction: column;">
            <label class="layui-form-label" style="padding-bottom: 0;padding-left: 0;">{{this.label}}</label>
            <p class="care-tips" style="color: red;display: flex;font-size: 12px;line-height: 1.5;">提示: 不要用特殊符号</p>
        </div>
        <div class="layui-input-block" style="margin-left: 25px;">
            <el-input
                v-for="value in dynamicTags"
                style="display: none"
                :name="name"
                :key="value+1"
                :value="value"
            >
            </el-input>
            <el-tag
                :key="tag"
                v-for="tag in dynamicTags"
                closable
                :disable-transitions="false"
                @close="handleClose(tag)">
                {{ tag }}
            </el-tag>
            <el-input
                class="input-new-tag"
                v-if="inputVisible"
                v-model="inputValue"
                ref="saveTagInput"
                size="small"
                @keyup.enter.native="handleInputConfirm"
                @blur="handleInputConfirm"
            >
            </el-input>
            <el-button v-else class="button-new-tag" size="small" @click="showInput">+ new</el-button>
        </div>
    </div>
</template>


<style>
.el-tag + .el-tag {
    margin-left: 10px;
}

.button-new-tag {
    margin-left: 10px;
    height: 32px;
    line-height: 30px;
    padding-top: 0;
    padding-bottom: 0;
}

.input-new-tag {
    width: 90px;
    margin-left: 10px;
    vertical-align: bottom;
}
</style>

<script>
export default {
    props:['data','name','label'],
    data() {
        return {
            dynamicTags: this.data,
            inputVisible: false,
            inputValue: '',
        };
    },
    methods: {
        handleClose(tag) {
            this.dynamicTags.splice(this.dynamicTags.indexOf(tag), 1);
        },

        showInput() {
            this.inputVisible = true;
            this.$nextTick(_ => {
                this.$refs.saveTagInput.$refs.input.focus();
            });
        },

        handleInputConfirm() {
            let inputValue = this.inputValue;
            if (inputValue) {
                this.dynamicTags.push(inputValue);
            }
            this.inputVisible = false;
            this.inputValue = '';
        }
    },
    mounted() {

    }
}
</script>
