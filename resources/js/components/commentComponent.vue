<template>

    <div>
        <div>
            <div class="comment-in py-3 pl-2">


                <P style="color: gray">{{comment.name}} - {{difforhumans}}</P>


                <div v-if="edit">
                    <textarea v-model="newBody" class="w-100"></textarea>
                </div>
                <div v-else>
                    <p>{{comment.body}}</p>
                </div>

                <div v-if="edit">
                    <button type="button" @click="cancel()" class="transparent-button">Cancel</button>
                    <button type="button" @click="update" class="transparent-button">Save</button>
                </div>
                <div v-else>
                    <div style="display: flex">
                        <p>
                            <i class="fa fa-reply"></i>
                            <button type="button" @click="$emit('respond-to',comment)" class="transparent-button">Reply
                            </button>
                        </p>

                        <p class="pl-2">
                            <i class="fa fa-edit"></i>
                            <button type="button" @click="edit=true" class="transparent-button">Edit</button>
                        </p>

                        <p class="pl-2">
                            <i class="fa fa-trash"></i>
                            <button type="button" @click="$emit('delete',comment)" class="transparent-button">Delete</button>
                        </p>

                    </div>
                </div>
            </div>
            <div class="pl-4" style="border-left: 1px solid gray">
                <comment :comment="child"
                         :now="now" v-for="child in comment.children"
                         :key="child.id"
                         @respond-to="$emit('respond-to',$event)"

                         @delete="delete_comment($event)"

                ></comment>
            </div>
        </div>
    </div>

</template>

<script>
    import {formatDistance} from 'date-fns'


    export default {
        name: 'comment',
        props: ['comment', 'now'],

        computed: {
            difforhumans() {
                return formatDistance(new Date(this.comment.created_at), this.now);
            }
        },

        data() {
            return {
                edit: false,
                newBody: this.comment.body,

            }
        },
        methods: {
            update() {
                this.comment.body=this.newBody;
                this.edit=false;

                axios.put('/comment', this.comment)

            },

            cancel(){
                this.edit=false;
                this.newBody=this.comment.body;
            },
            delete_comment(com){

                var comm=this.comment.children.filter( el => el.id !== com.id );
               comm=comm.filter( el => el.respond_to_id !== comment.id );
                this.comment.children=comm;

                  axios.delete('/comment/'+ btoa(com.id));

                console.log(com);

            }
        }
    }
</script>

