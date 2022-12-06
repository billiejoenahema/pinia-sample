<script setup>
const props = defineProps({
  links: {
    type: Array,
    required: false,
    default: () => [],
  },
});
const emit = defineEmits(["change"]);
const changePage = (url = null) => {
  const page = url?.substring(url.length - 1) || null;
  emit("change", page);
};
const linkLabel = (label) => {
  return label.replace("&laquo;", "<<").replace("&raquo;", ">>");
};
</script>

<template>
  <ul class="pagination">
    <li
      v-for="link in links"
      class="page-item"
      :class="{
        disabled: link.url === null,
        active: link.active,
      }"
      :tabindex="link.url === null ? '-1' : ''"
      @click.prevent="changePage(link.url)"
    >
      <a href="#" class="page-link">
        {{ linkLabel(link.label) }}
      </a>
    </li>
  </ul>
</template>
