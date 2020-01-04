<template>
    <div class="container2 ">
        <div>
            <comment :comment="comment"
                     :now="now"
                     v-for="comment in comments"
                     :key="comment.id"
                     @respond-to="respondTo=$event"
                     @delete="delete_comment($event)"
            ></comment>

        </div>
        <div class="my-3">
            <p class="text-center">
                <button v-if="nextPage" @click="fetchNext(nextPage)" class=" transparent-button ">
                    Charge the the next comments
                </button>
            </p>
        </div>

        <form-component @newComment="newComment"
                        :respond-to="respondTo"
                        @cancel-respond-to="respondTo=null"

        ></form-component>

    </div>
</template>

<script>
    export default {

        mounted() {

            setInterval(() => {
                this.now = new Date
            }, 1000);

            this.fetchNext('/comment/' + btoa(window.location.href));

        },

        data() {
            return {
                now: new Date(),
                comments: [],
                respondTo: null,
                nextPage: null,
            }
        },

        methods: {
            newComment(comment) {
                if (!this.respondTo) {
                    this.comments.push(comment);
                    return;
                }
                this.respondTo.children.push(comment);
            },
            fetchNext(url) {
                axios.get(url)
                    .then(({data: pagination}) => {
                        this.comments = this.comments.concat(pagination.data);
                        this.nextPage = pagination.next_page_url
                    })
            },

            delete_comment(comment){
                console.log(comment);
                console.log(this.comments);
                var comm=this.comments.filter( el => el.id !== comment.id );
                 comm=comm.filter( el => el.respond_to_id !== comment.id );
                 this.comments=comm;

                axios.delete('/comment/'+ btoa(comment.id));

                console.log(this.comments);

            }
        },
    }


</script>
