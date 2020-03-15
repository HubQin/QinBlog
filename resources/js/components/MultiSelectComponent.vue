<template>
    <div>
        <input type="hidden" :name="fieldName" :value="myTagIds">
        <multiselect
            v-model="value"
            tag-placeholder="添加为新标签"
            placeholder="请添加文章标签（下拉列表中选择或直接输入标签名）"
            select-label="按 Enter 选择"
            selected-label="已选"
            deselect-label="按 Enter 移除"
            label="name"
            track-by="id"
            :options="options"
            :multiple="true"
            :taggable="true"
            @tag="addTag"
        ></multiselect>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    export default {
        components: { Multiselect },
        props: {
            fieldName: {
                type: String,
                required: true
            },
            tagIds: {
                type: Array,
                default: () => [],
            },
            tags: {
                type: Array,
                required: true,
            },
        },
        data() {
            return {
                value: [],
                options: this.tags,
                myTagIds: this.tagIds
            }
        },
        methods: {
            addTag(newTag) {
                const tag = {
                    name: newTag,
                    id: newTag + '~' + Math.random().toString(36).substring(2)
                }
                this.options.push(tag);
                this.value.push(tag);
            }
        },
        mounted() {
            if (this.myTagIds && this.options.length > 0) {
                this.options.map((item) => {
                    if (this.myTagIds.includes(item.id)) {
                        this.value.push(item);
                    }
                })
            }
        },
        watch: {
            value(n, o) {
                let tagIds = [];
                n.map((item) => {
                    tagIds.push(item.id);
                });
                this.myTagIds = tagIds;
            }
        }
    }
</script>
