<template>
    <div>
        <input type="hidden" :name="fieldName" :value="myId">
        <multiselect v-model="value"
                     :hide-selected="true"
                     track-by="id"
                     label="name"
                     :placeholder="placeHolderAndLabels.placeholder"
                     :select-label="placeHolderAndLabels.selectLabel"
                     :tag-placeholder="placeHolderAndLabels.tagPlaceholder"
                     :options="options"
                     :allow-empty="false"
                     :taggable="isTaggable"
                     @tag="addTag"
        >
            <template slot="singleLabel" slot-scope="{ option }" v-if="!isTaggable">
                <div class="multiselect-category">
                    <svg class="icon" aria-hidden="true">
                        <use :xlink:href="'#' + option.icon"></use>
                    </svg>
                    <span class="single-label-slot">{{ option.name }}</span>
                </div>
            </template>
            <template slot="option" slot-scope="{ option }" v-if="!isTaggable">
                <div class="multiselect-category">
                    <svg class="icon" aria-hidden="true">
                        <use :xlink:href="'#' + option.icon"></use>
                    </svg>
                    <span class="option-slot">{{ option.name }}</span>
                </div>
            </template>
        </multiselect>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    export default {
        components: { Multiselect },
        props: {
            id: {
                type: Number,
                default: 0
            },
            options: {
                type: Array,
                required: true
            },
            fieldName: {
                type: String,
                required: true,
            },
            isTaggable: {
                type: Boolean,
                default: false
            },
            placeHolderAndLabels: {
                type: Object,
                default: () => new Object({
                            placeholder: "请选择文章分类",
                            selectLabel: "按 Enter 选择",
                            tagPlaceholder: "按 Enter 创建"
                })
            }
        },
        data () {
            return {
                value: "",
                myId: this.id
            }
        },
        mounted() {
            if (this.id && this.options.length > 0) {
                this.options.map((item) => {
                    if (item.id === this.id) {
                        this.value = item;
                    }
                })
            }
        },
        watch: {
            value(n, o) {
                this.myId = n.id;
            }
        },
        methods: {
            addTag(newTag) {
                const tag = {
                    name: newTag,
                    id: newTag + '~' + Math.random().toString(36).substring(2)
                }
                this.options.push(tag);
                this.value = tag;
            }
        }
    }
</script>
<style lang="scss">
    .multiselect-category {
        display: flex;
        align-items: center;
        justify-content: flex-start;

        .icon {
            width: 1em;
            height: 1em;
        }

        .option-slot, .single-label-slot {
            margin-left: 10px;
            font-size: 14px;
        }

        .single-label-slot {
            height: 25px;
            line-height: 25px;
        }
    }
    .multiselect__input {
        min-height:26px;
    }
    .multiselect__placeholder {
        padding-left: 5px;
    }
</style>
