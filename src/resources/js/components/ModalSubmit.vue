<script setup>
defineProps({
  id: {
    type: String,
    required: true,
    default: "exampleModal",
  },
  confirmText: {
    type: String,
    required: false,
    default: "保存してもよろしいですか？",
  },
  cancelButtonValue: {
    type: String,
    required: false,
    default: "キャンセル",
  },
  submitButtonValue: {
    type: String,
    required: false,
    default: "保存する",
  },
});
const emit = defineEmits(["submit"]);
const submit = () => {
  emit("submit");
};
</script>

<template>
  <div class="modal" :id="id" tabindex="-1" :aria-labelledby="id + 'Label'">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" :id="id + 'ModalLabel'">{{ confirmText }}</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            {{ cancelButtonValue }}
          </button>
          <button type="button" class="btn btn-primary" @click="submit">
            {{ submitButtonValue }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
