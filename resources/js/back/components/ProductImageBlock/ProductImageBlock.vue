<template>
    <div class="row">
        <div class="col-sm-12">
            <slim-cropper :options="block.slim_opt">
                <input type="file" name="image_blocks[][image]"/>
            </slim-cropper>
        </div>
        <div class="col-sm-12">
            <div class="row mt-10 form-group">
                <div class="col-sm-6">
                    Sort order
                </div>
                <div class="col-sm-6">
                    <input type="text" class="form-control" v-model="block.sort_order" name="image_blocks[][sort_order]" placeholder="Set sort order...">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Slim from '../../plugins/slim/slim'

    export default {
        components: {
            'slim-cropper': Slim
        },
        //
        props: {
            image: {
                type: String,
                required: true,
            },
            resourceId: {
                type: [String, Number],
                required: false,
                default: null,
            },
            rowId: {
                type: String,
                required: false,
                default: false,
            }
        },
        //
        data () {
            return {
                block: {
                    id: this.resourceId ? this.resourceId : 0,
                    sort_order: 0,
                    image: '',
                    slim_opt: {
                        ratio: '1:1',
                        size: this.imageSavingDimensions,
                        initialImage: this.image,
                        //service: false,//this.imageService,
                        didInit: this.imageInit,
                        //didRemove: this.imageRemove,
                        didLoad: this.imageLoad,
                    },
                    new: false,
                }
            }
        },
        //
        mounted () {
            console.log('Product Image Block ::: ')
            console.log(this.block)
        },
        //
        methods: {
            //
            // called when slim has initialized
            imageInit(data, slim) {
                console.log('slimInit - ', slim)
            },
            //
            // called when upload button is pressed or automatically if push is enabled
            imageService(formdata, progress, success, failure, slim) {
                console.log('slimService - ', slim)
                // form data to post to server
                // set serviceFormat to "file" to receive an array of files
            },
            //
            imageRemove(server, slim) {
                console.log(server)
                console.log(slim)
            },

            imageLoad(filedata, canvas, buffer, slim) {
                console.log(slim)
                console.log(this.block)

                return true;
            },
            //
            //
            deleteBlock(block) {
                let cx = this;

                console.log(block)

                axios.post('deleteUrl.php', { data: block.id })
                    .then(r => {
                        console.log(r)
                    })
                    .catch(e => {
                        console.log(e)
                    })
            },
        }
    };
</script>
