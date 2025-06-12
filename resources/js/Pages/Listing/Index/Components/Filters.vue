<template>
    <form @submit.prevent="filter">
        <div class="mb-8 mt-4 flex flex-wrap gap-2">
            <div class="flex flex-nowrap items-center">
                <input v-model.number="filterForm.priceFrom"
                    type="text" placeholder="Price from"
                    class="input-filter-l w-28"/>
                <input v-model.number="filterForm.priceTo"
                    type="text" placeholder="Price to"
                    class="input-filter-r w-28"/>
            </div>

            <div class="flex flex-nowrap items-center">
                <select class="input-filter-l w-28" v-model="filterForm.beds">
                    <option :value="null">Beds</option>
                    <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
                    <option>6+</option>
                </select>
                <select class="input-filter-r w-28" v-model="filterForm.baths">
                    <option :value="null">Baths</option>
                    <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
                    <option>6+</option>
                </select>
            </div>

            <div class="flex flex-nowrap items-center">
                <input v-model="filterForm.areaFrom"
                    type="text" placeholder="Area from"
                    class="input-filter-l w-28"/>
                <input v-model="filterForm.areaTo"
                    type="text" placeholder="Area to"
                    class="input-filter-r w-28"/>
            </div>

            <button type="submit" class="btn-normal cursor-pointer">Filter</button>
            <button type="reset" @click="clear" class="cursor-pointer">Clear</button>
        </div>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { route } from 'ziggy'

const props = defineProps({
  filters: Object,
})

const filterForm = useForm({
  priceFrom: props.filters.priceFrom ?? null,
  priceTo: props.filters.priceTo ?? null,
  beds: props.filters.beds ?? null,
  baths: props.filters.baths ?? null,
  areaFrom: props.filters.areaFrom ?? null,
  areaTo: props.filters.areaTo ?? null,
})

const filter = () => {
  filterForm.get(route('listing.index'), {
    preserveState: true,
    preserveScroll: true,
  })
}

const clear = () => {
  filterForm.priceFrom = null
  filterForm.priceTo = null
  filterForm.beds = null
  filterForm.baths = null
  filterForm.areaFrom = null
  filterForm.areaTo = null
  filter()
}
</script>
