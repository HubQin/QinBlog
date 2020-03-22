<template>
    <div ref="toc" class="vue-toc"/>
</template>

<script>
    export default {
        props: {
            // class name, like ".class"
            targetClass: {
                type: String,
                required: true
            },
            h2Class: {
                type: String,
                default: 'toc-2'
            },
            h3Class: {
                type: String,
                default: 'toc-3'
            },
        },
        mounted() {
            this.$nextTick(() => {
                const toc = this.$refs.toc;
                const matches = document.querySelectorAll(`${this.targetClass} h2, ${this.targetClass} h3`);
                console.log(matches)
                matches.forEach(item => {
                    item.id = '#' + Math.random().toString(36).substring(7);
                    if (item.tagName === 'H2') {
                        const ul = document.createElement('ul');
                        const li = document.createElement('li');
                        const a = document.createElement('a');

                        a.innerHTML = item.textContent;
                        a.href = `#${item.id}`;

                        li.appendChild(a);
                        li.classList.add(this.h2Class);
                        ul.appendChild(li);
                        toc.appendChild(ul);
                    }
                    if (item.tagName === 'H3') {
                        const ul = document.createElement('ul');
                        const li = document.createElement('li');
                        const a = document.createElement('a');

                        const lastUl = toc.lastElementChild;
                        const lastLi = lastUl.lastElementChild;

                        a.innerHTML = item.textContent;
                        a.href = `#${item.id}`;
                        li.appendChild(a);

                        li.classList.add(this.h3Class);

                        ul.appendChild(li);

                        lastLi.appendChild(ul);
                    }
                });
            });
        }
    };
</script>
