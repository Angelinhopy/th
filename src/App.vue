<template>
  <transition mode="out-in">
    <router-view/>
  </transition>
</template>

<script>

export default {
  name: 'App',
  components: {
  },
  data: () => ({
  }),
}
</script>

<style lang="scss">
	@import "@/styles/index.scss";

	/* Remove in 1.2 */
	.v-datatable thead th.column.sortable i {
		vertical-align: unset;
	}
</style>
