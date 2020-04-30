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

    beforeMount() {
        // api.books()
        //     .then(data => data.data.data)
        //     .then(data => console.log(data));
    },

    components: {
        TopBar,
        DataTable
    },

    data: () => ({})
};
</script>
