<script setup>
import { computed, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useConstsStore } from "../stores/consts";
import { useUserStore } from "../stores/user";

const props = defineProps({
  id: {
    type: String,
    required: true,
    default: null,
  },
});
const router = useRouter();
const store = useUserStore();
const constsStore = useConstsStore();

onMounted(async () => {
  await store.get(router.currentRoute.value?.params?.id);
  await constsStore.getIfNeeded();
});
const user = computed(() => store.data);
const backToIndex = () => {
  router.push(`/`);
};
</script>

<template>
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="#" @click.prevent="backToIndex()">back</a>
    </li>
  </ul>
  <div class="h3">User Detail</div>
  <div class="card">
    <div class="card-body">
      <p>id: {{ user.id }}</p>
      <p>user_name: {{ user.name }}</p>
      <p>email: {{ user.email }}</p>
      <p>phone: {{ user.phone }}</p>
      <p>updated_at: {{ user.updated_at }}</p>
    </div>
  </div>
</template>
