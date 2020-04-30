<template>
    <v-row>
        <v-col cols="12">
            <v-data-table
                :headers="tableHeaders"
                :items="tableBody"
                class="elevation-1"
                fixed-header
                mobile-breakpoint="0"
            >
                <template v-slot:item.author="{ item }">
                    {{ item.author }}
                    <v-icon small class="ml-1" @click="() => {}">
                        mdi-magnify
                    </v-icon>
                </template>
                <template v-slot:item.actions>
                    <v-icon small @click="() => {}">
                        mdi-delete
                    </v-icon>
                </template>
            </v-data-table>
        </v-col>
    </v-row>
</template>

<script>
export default {
    name: "DataTable",

    data: () => ({
        tableHeaders: [
            { text: "ID", value: "id" },
            { text: "Title", value: "title" },
            {
                text: "Author",
                value: "author",
                sort: function(a, b) {}
            },
            {
                text: "Actions",
                value: "actions",
                sortable: false,
                align: "center"
            }
        ],
        tableBody: [
            {
                id: 1,
                title: "Hello world 1",
                author: "Foo bar 3"
            },
            {
                id: 2,
                title: "Hello world 2",
                author: "Foo bar 2"
            },
            {
                id: 3,
                title: "Hello world 3",
                author: "Foo bar 1"
            }
        ]
    })
};
</script>
