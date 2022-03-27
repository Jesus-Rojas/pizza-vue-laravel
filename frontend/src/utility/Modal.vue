<template>
  <Transition name="fade">
    <div class="modal-backdrop">
      <div class="modal-container" :class="classCustom">
        <div class="header-modal" v-if="showHeader">
          <slot name="header"></slot>
        </div>
        <div class="body-modal">
          <slot name="body"></slot>
        </div>
        <div class="footer-modal">
          <slot name="footer"></slot>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script>
import { ref } from '@vue/reactivity';

export default {
  props: {
    classCustom: {
      type: String,
      default: ''
    },
    showHeader: {
      type: Boolean,
      default: true
    },
  },
  data(){
    return {
			show: false,
    }
  }
}
</script>

<style scoped lang='scss'>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.modal-backdrop {
  position: fixed;
  z-index: 999;
  width: 100%;
  height: 100vh;
  top: 0;
  left: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-container {
  width: 40%;
  height: 35%;
  background: #fff;
  text-align: center;
  display: flex;
  flex-direction: column;
  justify-content: space-evenly;
  position: relative;
  border-radius: 10px;
}

.size-modal-pizza {
  height: 75%;
}

.size-modal-addCar {
  height: 80%;
}
</style>