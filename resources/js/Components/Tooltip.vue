<template>
  <div ref="tooltipWrapper" class="">
    <slot></slot>
  </div>
</template>

<script>
import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css';

export default {
  props: {
    content: {
      type: String,
      required: true
    },
    placement: {
      type: String,
      default: 'top'
    }
  },
  mounted() {
    this.tooltipInstance = tippy(this.$refs.tooltipWrapper, {
      content: this.content,
      placement: this.placement,
      appendTo: document.body, // Menempatkan tooltip di body
      arrow: true,
      animation: 'shift-away',
      delay: [2000, 0], // Menambahkan penundaan 2 detik sebelum muncul
      onShow(instance) {
        instance.popper.style.position = 'absolute';
      },
      onHidden(instance) {
        instance.popper.style.position = '';
      }
    });
  },
  beforeDestroy() {
    if (this.tooltipInstance) {
      this.tooltipInstance.destroy();
    }
  }
}
</script>