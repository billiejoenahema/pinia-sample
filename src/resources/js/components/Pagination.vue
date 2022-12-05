<script setup>
const props = defineProps({
  links: {
    type: Array,
    required: false,
    default: () => [],
  },
});
const emit = defineEmits(["change"]);
const changePage = (url) => {
  const page = url.substring(url.length - 1);
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
      :disabled="link.url === null"
      class="page-item"
      :class="{
        'pagination-link-enabled': link.url !== null,
        'pagination-link-active': link.active,
      }"
      @click.prevent="changePage(link.url)"
    >
      <a href="#" class="page-link">
        {{ linkLabel(link.label) }}
      </a>
    </li>
  </ul>
</template>
