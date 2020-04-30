<template>
    <v-row align="center">
        <v-col cols="12" md="8" class="py-0">
            <SearchBar />
        </v-col>
        <v-col cols="12" md="4" class="py-0">
            <v-row>
                <v-col cols="6" class="py-0">
                    <CreateBookButton />
                </v-col>
                <v-col cols="6" class="py-0">
                    <ExportButton />
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</template>

<script>
import SearchBar from "./TopBar/SearchBar";
import CreateBookButton from "./Buttons/CreateBookButton";
import ExportButton from "./Buttons/ExportButton";

export default {
    name: "TopBar",

    components: {
        SearchBar,
        CreateBookButton,
        ExportButton
    }
};
</script>
