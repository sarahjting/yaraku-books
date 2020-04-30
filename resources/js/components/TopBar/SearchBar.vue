<template>
    <v-row>
        <v-col cols="12" sm="6" md="4" class="py-0">
            <v-select
                :items="['Author', 'Title']"
                value="Author"
                label="Search by"
                prepend-icon="mdi-database-search"
            ></v-select>
        </v-col>
        <v-col cols="12" sm="6" md="8" class="py-0">
            <v-autocomplete
                :items="['Foo Bar', 'Test Bar', 'Foo Test']"
                placeholder="Start typing to Search"
                return-object
            ></v-autocomplete>
        </v-col>
    </v-row>
</template>

<script>
export default {
    name: "SearchBar"
};
</script>
