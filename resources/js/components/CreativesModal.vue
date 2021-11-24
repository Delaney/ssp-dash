<template>
    <div>
        <transition name="modal">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container" id="mac">

                        <div class="modal-header">
                            <slot name="header">
                                <h2 class="text-2xl bg-gray-700 p-4 rounded-sm text-white text-center">CREATIVES</h2>
                            </slot>
                        </div>

                        <div class="modal-body">
                            <slot name="body">
                                <div class="mx-auto px-1 my-1">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-2">
                                        <div v-for="creative in creatives" :key="creative.id" class="flex justify-center text-6xl border-0 border-gray-600 rounded-sm p-1 bg-gray-500 hover:bg-gray-700">
                                            <img class="w-full rounded-sm bg-gray-500" :src="creative.link" />
                                        </div>
                                    </div>
                                </div>
                            </slot>
                        </div>

                        <div class="modal-footer">
                            <slot name="footer">
                                <button class="modal-default-button" @click="$emit('close')">
                                    Close
                                </button>
                            </slot>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
export default {
    props: {
        creatives: {
            type: Array,
            required: true,
        }
    },
}
</script>

<style scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 500px;
  height: 100%;
  margin: 80px auto 0;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  overflow: scroll;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>