<template>
    <div>
        <input type="hidden" :name="fieldName" :value="myCategoryId">
        <multiselect v-model="value"
                     :hide-selected="true"
                     track-by="id"
                     label="name"
                     placeholder="请选择文章分类"
                     select-label="按 Enter 选择"
                     :options="options"
                     :allow-empty="false"
        >
            <template slot="singleLabel" slot-scope="{ option }">
                <div class="multiselect-category">
                    <svg class="icon" aria-hidden="true">
                        <use :xlink:href="'#' + option.icon"></use>
                    </svg>
                    <span class="single-label-slot">{{ option.name }}</span>
                </div>
            </template>
            <template slot="option" slot-scope="{ option }">
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
            categoryId: {
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
        },
        data () {
            return {
                value: "",
                myCategoryId: this.categoryId
            }
        },
        mounted() {
            if (this.categoryId && this.options.length > 0) {
                this.options.map((item) => {
                    if (item.id === this.categoryId) {
                        this.value = item;
                    }
                })
            }
        },
        watch: {
            value(n, o) {
                this.myCategoryId = n.id;
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
            font-size:14px;
        }

        .single-label-slot {
            height: 25px;
            line-height: 25px;
        }
    }
</style>
