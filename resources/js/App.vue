<template>
    <v-app>
        <v-row align="center" justify="center">
            <v-col cols="10">
                <TopBar />
                <DataTable />
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

    beforeMount() {},

    components: {
        TopBar,
        DataTable
    },

    computed: {},

    data: () => ({})
};
</script>
