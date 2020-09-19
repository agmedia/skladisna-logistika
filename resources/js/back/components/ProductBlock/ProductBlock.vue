<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div v-for="(block, index) in blocks" :class="'col-sm-12 col-md-' + blockSize + ' mb-20'" :ref="index">
                    <div class="row">
                        <div :class="'col-sm-12 col-md-' + imageSize">
                            <slim-cropper :options="block.slim_opt" :id="'slim-cropper-' + index">
                                <input type="file" :name="'blocks[' + index + '][image]'" :id="'image_' + index"/>
                            </slim-cropper>
                        </div>
                        <div :class="'col-sm-12 col-md-' + (12 - imageSize)">
                            <div class="row">
                                <div class="col-sm-12 mb-20">
                                    <input type="text" class="form-control" v-model="block.title" :name="'blocks[' + index + '][title]'" placeholder="Enter block title...">
                                    <input type="hidden" :name="'blocks[' + index + '][id]'" v-model="block.id">
                                </div>
                                <div class="col-sm-12 mb-20">
                                    <textarea class="form-control" rows="3" v-model="block.description" :name="'blocks[' + index + '][description]'" placeholder="Enter block description..."></textarea>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-4 col-lg-3">
                                            <span class="pt-5">Sort order</span>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3">
                                            <input type="text" class="form-control" v-model="block.sort_order" :name="'blocks[' + index + '][sort_order]'" placeholder="Set sort order...">
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-lg-6 text-right" v-if="resourceId && !block.new">
                                            <a href="#" @click.prevent="deleteBlock(block)" :class="'btn btn-square ' + block.deleteClass + ' mr-5 mb-5'">{{ block.deleteLabel }}</a>
                                            <!--<a href="#" @click.prevent="saveBlock(block)" :class="'btn btn-square ' + block.saveClass + ' mr-5 mb-5'">{{ block.saveLabel }}</a>-->
                                        </div>
                                        <!--<div class="col-sm-12 col-md-4 col-lg-6 text-right" v-else>
                                            <a href="#" @click.prevent="removeBlock(index)" class="btn btn-square btn-outline-danger mr-5 mb-5">Remove</a>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" id="images">

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <a href="#" @click.prevent="addNewBlock" class="btn btn-square btn-primary mr-5 mb-5">
                        <i class="fa fa-wifi mr-5"></i> Add New Block
                    </a>
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
            hasBlocks: {
                type: Object,
                required: false,
                default: null,
            },
            resourceId: {
                type: [String, Number],
                required: false,
                default: null,
            },
            saveUrl: {
                type: String,
                required: false,
                default: window.location.origin + '/admin/apiv1/products/save-block',
            },
            deleteUrl: {
                type: String,
                required: false,
                default: window.location.origin + '/admin/apiv1/products/destroy-block',
            },
            blockSize: {
                type: [String, Number],
                required: false,
                default: 6,
            },
            imageSize: {
                type: [String, Number],
                required: false,
                default: 4,
            },
            imageSavingDimensions: {
                type: String,
                required: false,
                default: '360,360',
            }
        },
        //
        data () {
            return {
                blocks: []
            }
        },
        //
        mounted () {
            if (this.hasBlocks) {
                this.hasBlocks = JSON.parse(this.hasBlocks);

                this.init();
            }
        },
        //
        methods: {
            //
            init() {
                this.hasBlocks.forEach((item) => {
                    let key = this.blocks.length;

                    this.blocks.push({
                        id: item.id,
                        uid: key,
                        product_id: this.resourceId ? this.resourceId : 0,
                        title: item.title,
                        description: item.description,
                        sort_order: item.sort_order,
                        image: '',
                        slim_opt: {
                            ratio: '1:1',
                            size: this.imageSavingDimensions,
                            initialImage: window.location.origin + '/' + item.image,
                            service: false,//this.imageService,
                            didInit: this.imageInit,
                            didRemove: this.imageRemove,
                            didLoad: this.imageLoad,
                        },
                        new: false,
                        saveLabel: 'Save',
                        saveClass: 'btn-outline-success',
                        deleteLabel: 'Delete',
                        deleteClass: 'btn-outline-danger',
                    });
                });
            },
            //
            // called when slim has initialized
            imageInit(data, slim) {
                // slim instance reference
                console.log('slimInit - ', slim)
                // current slim data object and slim reference
                //console.log(data)
            },
            //
            // called when upload button is pressed or automatically if push is enabled
            imageService(formdata, progress, success, failure, slim) {
                console.log('slimService - ', slim)
                // form data to post to server
                // set serviceFormat to "file" to receive an array of files
                //console.log(formdata)
                // call these methods to handle upload state
                //console.log(progress, success, failure)
            },
            //
            imageRemove(server, slim) {
                let index = 0;

                console.log(server)
                console.log(slim)
                console.log(this.blocks)

                //this.blocks.splice(this.blocks.length - 1, 1);
            },

            imageLoad(filedata, canvas, buffer, slim) {
                this.blocks[slim._uid].image = slim.data.input.file;

                console.log(slim._uid)
                console.log(this.blocks)

                return true;
            },
            //
            //
            saveBlock(block) {
                let cx = this;

                axios({
                    method: ('post'),
                    url: cx.saveUrl,
                    data: block,
                    headers: { 'Content-Type': block.new ? 'multipart/form-data' : 'application/json' },
                }).then(r => {
                    console.log(r.data)
                    if (r.data) {
                        this.blocks.forEach((item) => {
                            if (item.id == block.id) {
                                item.saveLabel = 'Saved';
                                item.saveClass = 'btn-success';
                            }
                        });
                    }
                }).catch(e => {
                    console.log(e)
                })
            },
            //
            //
            deleteBlock(block) {
                let cx = this;

                console.log(block)

                axios.post(cx.deleteUrl, { data: block.id })
                    .then(r => {
                        this.blocks.forEach((item) => {
                            if (item.id == block.id) {
                                item.deleteLabel = 'Deleted';
                                item.deleteClass = 'btn-danger';
                            }
                        });
                    })
                    .catch(e => {
                        console.log(e)
                    })
            },
            //
            //
            removeBlock(index) {
                this.blocks.forEach((item) => {
                    if (item.id == index) {
                        item.removeLabel = 'Removed';
                        item.removeClass = 'btn-danger';
                    }
                });
            },
            //
            //
            addNewBlock() {
                let key = this.blocks.length;

                this.blocks.push({
                    id: 0,
                    product_id: this.resourceId ? this.resourceId : 0,
                    title: '',
                    description: '',
                    sort_order: key + 1,
                    image: '',
                    slim_opt: {
                        ratio: '1:1',
                        size: this.imageSavingDimensions,
                        service: false,
                        didInit: this.imageInit,
                        didRemove: this.imageRemove,
                        didLoad: this.imageLoad,
                    },
                    new: true,
                    saveLabel: 'Save',
                    saveClass: 'btn-outline-success',
                    deleteLabel: 'Delete',
                    deleteClass: 'btn-outline-danger',
                });

                console.log(this.blocks)
            }
        }
    };
</script>
