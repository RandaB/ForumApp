<template>
    <form  @submit.prevent="submitComment" class="form">
        <div>
            <p>New comment</p>
            <div  v-if="respondTo" style="display: flex;">
                <p> Reply to <span>{{respondTo.name}}</span> =" {{respondTo.body}} "
                <button @click="$emit('cancel-respond-to')" class="transparent-button">Cancel</button></p>
            </div>

        </div>

        <input type="text" placeholder="Enter your name" name="name" id="name" v-model="form.name" :class="{'border-red': errors.name}"/>
        <p v-if="errors.name" v-text="errors.name[0]" class="error"></p>

        <textarea v-model="form.body" placeholder="Enter your comment" :class="{'border-red': errors.body}"></textarea>
        <p v-if="errors.body" v-text="errors.body[0]" class="error"></p>

        <button type="submit" class="pink-button">Comment</button>
    </form>
</template>

<script>
    export default {
        props:['respondTo'],
        computed:{
            fullForm(){
                if(this.respondTo){
                    return{
                        name: this.form.name,
                        body: this.form.body,
                        url: this.form.url,
                        respond_to_id: this.respondTo.id,
                    };

                }
                return{
                    name: this.form.name,
                    body: this.form.body,
                    url: this.form.url,
                }

            }
        },



        methods: {
            submitComment() {
                axios.post('/comment', this.fullForm)
                    .then(({data}) => {
                        this.$emit('newComment',data);

                        this.form.name = '';
                        this.form.body = '';
                    })
                    .catch(error => {
                            this.errors = error.response.data.errors;
                        }
                    );
                console.log(this.comment);
            }
        },
        data() {
            return {
                form: {
                    body: '',
                    name: '',
                    url: window.location.href,
                },
                errors: {},



            }
        }
    }
</script>

<style scoped>

</style>