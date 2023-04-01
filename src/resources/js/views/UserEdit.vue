<script setup>
import { computed, onMounted, onUnmounted, ref } from "vue";
import { useRouter } from "vue-router";
import InputDateSplit from "../components/InputDateSplit.vue";
import InputText from "../components/InputText.vue";
import { useConstsStore } from "../stores/consts";
import { useUserStore } from "../stores/user";

const router = useRouter();
const store = useUserStore();
const constsStore = useConstsStore();
const userId = ref(null);

onMounted(async () => {
  userId.value = router.currentRoute.value?.params?.id;
  await store.get(userId.value);
  await constsStore.getIfNeeded();
});
const user = computed(() => store.data);
const numOfChar = ref(0);
const backToDetail = () => {
  router.push(`/users/${userId.value}`);
};
onUnmounted(() => {
  store.user = {};
});
</script>

<template>
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="#" @click.prevent="backToDetail()">back</a>
    </li>
  </ul>
  <div class="h3">User Edit</div>
  <div class="card">
    <div class="card-body">
      <p class="avatar">
        <img :src="user.avatar" hight="80" />
      </p>
      <label>ID</label>
      <div>{{ user.id }}</div>
      <label for="name">user_name</label>
      <InputText
        id="name"
        type="text"
        autocomplete="on"
        :character-count="true"
        maxlength="50"
        placeholder="山田 太郎"
        autocorrect="name"
        inputmode="text"
        v-model="user.name"
      />
      <label for="kana_name">user kana_name</label>
      <InputText
        id="kana_name"
        type="text"
        autocomplete="on"
        maxlength="50"
        placeholder="ヤマダ タロウ"
        autocorrect="name"
        inputmode="text"
        help-text="カタカナのみ"
        v-model="user.kana_name"
      />
      <p>kana_name: {{ user.kana_name }}</p>
      <p class="d-flex">
        birth_date:&nbsp;
        <InputDateSplit v-model="user.birth_date" id="birth_date" />
      </p>
      <p>email: {{ user.email }}</p>
      <p>phone: {{ user.phone }}</p>
      <p>address: {{ user.address }}</p>
      <p>remarks: {{ user.remarks }}</p>
      <p>updated_at: {{ user.updated_at }}</p>
    </div>
  </div>
</template>

<style>
.avatar > img {
  height: 160px;
}
.input-file {
  position: relative;
  z-index: 1;
}
.preview-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 160px;
  height: 160px;
  z-index: 2;
}
</style>
