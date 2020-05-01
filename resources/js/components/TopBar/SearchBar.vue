<template>
    <v-row>
        <v-col cols="12" sm="6" md="4" class="py-0">
            <v-select
                ref="filterBy"
                :items="['Title', 'Author']"
                v-model="$store.state.filterBy"
                value="Author"
                label="Search by"
                prepend-icon="mdi-database-search"
            ></v-select>
        </v-col>
        <v-col cols="12" sm="6" md="8" class="py-0">
            <v-text-field
                v-model="$store.state.filter"
                placeholder="Start typing to Search"
            ></v-text-field>
        </v-col>
    </v-row>
</template>

<script>
export default {
    name: "SearchBar"
};
</script>
