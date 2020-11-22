<template>
    <div class="modal" :class="(showDialog == true ? 'show' : '')">
        <div class="modal-dialog">
            <div class="modal-content b-0">
                
            <div class="modal-body">
                <div class="modal-header p-0 b-0 mb-3">
                    <h4 class="modal-title">{{title}}</h4>
                    <button type="button" class="close" @click="cancel">&times;</button>
                </div>
                <p>{{subtitle}}</p>
                <div class="modal-footer b-0 p-0">
                    <CustomButton :class="'btn btn-success'" @click="save" :loading="btnLoading">{{yestext}}</CustomButton>
                    <button type="button" class="btn btn-light" @click="cancel">Cancel</button>
                </div>
                
            </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: String,
        subtitle: String,
        yestext: String,
        showDialog: {
            default: false,
            type: Boolean
        }
    },
    data() {
        return {
            btnLoading: false,
        }
    },
    methods: {
        save() {
            this.$emit('yesfn', true);
            this.btnLoading = true;
        },
        cancel() {
            this.$emit('cancelfn', true);
        }
    },
    watch: {
        showDialog: function(newVal) {
            if(newVal) {
                this.btnLoading = false;
            }
        }
    }
}
</script>