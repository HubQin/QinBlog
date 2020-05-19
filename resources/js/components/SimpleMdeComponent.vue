<template>
    <div :class="editorClassName">
        <textarea :name="fieldName" ref="textarea" v-html="myContent"></textarea>
    </div>
</template>

<script>
    export default {
        props: {
            editorClassName: {
                type: String,
                default: 'simplemde-component',
            },
            fieldName: {
                type: String,
                default: 'body',
            },
            content: {
                type: String,
                default: 'Test',
            },
        },
        data() {
            return {
                simplemde: null,
                myContent: this.content
            }
        },
        mounted() {
            this.simplemdeInit();
        },
        methods: {
            simplemdeInit() {
                window.SimpleMDE = require('simplemde');
                this.simplemde = new SimpleMDE({
                    autofocus: true,
                    status: false,
                    autosave: {
                        enabled: false, // 关闭自动保存
                        uniqueId: 'demo',
                        delay: 2000,
                    },
                    element: this.$refs.textarea,
                    forceSync: true,
                    indentWithTabs: false,
                    initialValue: this.myContent ? this.myContent : 'Hello world',
                    lineWrapping: true,
                    parsingConfig: {
                        allowAtxHeaderWithoutSpace: true,
                        strikethrough: true,
                        underscoresBreakWords: true,
                    },
                    placeholder: "Type here...",
                    insertTexts: {
                        horizontalRule: ["", "\n\n-----\n\n"],
                        image: ["![](https://", ")"],
                        link: ["[", "](https://)"],
                        table: ["", "\n\n| Column 1 | Column 2 | Column 3 |\n| -------- | -------- | -------- |\n| Text     | Text      | Text     |\n\n"],
                    },
                    spellChecker: false,  // 开启拼写检查程序
                    renderingConfig: { // 在预览期间调整解析标记的设置
                        codeSyntaxHighlighting: true // 开启代码高亮
                    },
                    autoDownloadFontAwesome: false,  // 不要从CDN加载font awesome，使用本项目自己引入的
                    /*previewRender: (plainText, preview) => { // Async method
                        setTimeout(() => {
                            preview.innerHTML = this.simplemde.markdown(plainText);
                            hljs.highlightAuto(preview.innerHTML)
                        }, 250);

                        return "Loading...";
                    },*/
                    tabSize: 4, // 自定义缩进间距
                    hideIcons: ["heading"], // 隐藏图标
                    showIcons: ["code", "horizontal-rule", "table", "strikethrough", "heading-1", "heading-2", "heading-3"],
                    toolbar: [

                        {
                            name: "bold",
                            action: SimpleMDE.toggleBold,
                            className: "fa fa-bold",
                            title: "加粗"
                        },

                        {
                            name: "bold",
                            action: SimpleMDE.toggleItalic,
                            className: "fa fa-italic",
                            title: "斜体"
                        },

                        {
                            name: "strikethrough",
                            action: SimpleMDE.toggleStrikethrough,
                            className: "fa fa-strikethrough",
                            title: "删除线"
                        },

                        '|',

                        {
                            name: "heading",
                            action: SimpleMDE.toggleHeadingSmaller,
                            className: "fa fa-header",
                            title: "一级标题"
                        },

                        {
                            name: "heading-1",
                            action: SimpleMDE.toggleHeading1,
                            className: "fa fa-header fa-header-x fa-header-1",
                            title: "一级标题"
                        },

                        {
                            name: "heading-2",
                            action: SimpleMDE.toggleHeading2,
                            className: "fa fa-header fa-header-x fa-header-2",
                            title: "二级标题"
                        },

                        {
                            name: "heading-3",
                            action: SimpleMDE.toggleHeading1,
                            className: "fa fa-header fa-header-x fa-header-3",
                            title: "三级标题"
                        },

                        '|',

                        {
                            name: "code",
                            action: SimpleMDE.toggleCodeBlock,
                            className: "fa fa-code",
                            title: "代码"
                        },

                        {
                            name: "quote",
                            action: SimpleMDE.toggleBlockquote,
                            className: "fa fa-quote-left",
                            title: "引用"
                        },

                        {
                            name: "unordered-list",
                            action: SimpleMDE.toggleUnorderedList,
                            className: "fa fa-list-ul",
                            title: "无序列表"
                        },

                        {
                            name: "ordered-list",
                            action: SimpleMDE.toggleOrderedList,
                            className: "fa fa-list-ol",
                            title: "有序列表"
                        },

                        {
                            name: "horizontal-rule",
                            action: SimpleMDE.drawHorizontalRule,
                            className: "fa fa-minus",
                            title: "插入水平线"
                        },

                        '|',

                        {
                            name: "link",
                            action: SimpleMDE.drawLink,
                            className: "fa fa-link",
                            title: "创建链接"
                        },

                        {
                            name: "image",
                            action: SimpleMDE.drawImage,
                            className: "fa fa-picture-o",
                            title: "插入图片"
                        },

                        {
                            name: "table",
                            action: SimpleMDE.drawTable,
                            className: "fa fa-table",
                            title: "插入表格"
                        },

                        '|',

                        {
                            name: "preview",
                            action: SimpleMDE.togglePreview,
                            className: "fa fa-eye no-disable",
                            title: "预览"
                        },

                        {
                            name: "side-by-side",
                            action: SimpleMDE.toggleSideBySide,
                            className: "fa fa-columns no-disable no-mobile",
                            title: "编辑并预览"
                        },

                        {
                            name: "fullscreen",
                            action: SimpleMDE.toggleFullScreen,
                            className: "fa fa-arrows-alt no-disable no-mobile",
                            title: "全屏"
                        },

                        {
                            name: "guide",
                            action: function customFunction(editor) {
                                window.open("https://github.com/pudongping/Markdown-Syntax-CN")
                            },
                            className: "fa fa-question-circle",
                            title: "帮助"
                        }
                    ]
                });

                this.simplemde.value(this.myContent);

                this.simplemde.codemirror.on("change", () => {
                    this.myContent = this.simplemde.value();
                });

                // 拖拽上传
                const inlineAttachmentConfig = {
                    uploadUrl: '/posts/upload_post_image',
                    extraHeaders: {
                        'X-CSRF-Token': document.head.querySelector('meta[name="csrf-token"]').content
                    },
                    progressText: '![图片上传中...]()',
                    urlText: "![image]({filename})",
                    errorText: "图片上传失败！",
                };
                inlineAttachment.editors.codemirror4.attach(this.simplemde.codemirror, inlineAttachmentConfig);
            },
            highlightCode(html) {
                return hljs.highlightAuto(html).value;
            }
        }
    }
</script>
