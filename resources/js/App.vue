<template>
    <v-app>
        <v-row align="center" justify="center">
            <v-col cols="10" align="center">
                <TopBar />
                <v-progress-circular
                    v-if="$store.state.isLoading"
                    indeterminate
                />
                <DataTable v-if="!$store.state.isLoading" />
            </v-col>
        </v-row>
    </v-app>
</template>

<script>
import api from "./api/index";

import TopBar from "./components/TopBar";
import DataTable from "./components/DataTable";

export default {
    name: "App",
    components: {
        TopBar,
        DataTable
    },
    beforeMount() {
        this.$store.dispatch("loadBooks");
    }
};
</script>
