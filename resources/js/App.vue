<template>
    <v-app>
        <v-row align="center" justify="center">
            <v-col cols="10">
                <v-row align="center">
                    <v-col cols="12" md="8" class="py-0">
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
                    </v-col>
                    <v-col cols="12" md="4" class="py-0">
                        <v-row>
                            <v-col cols="6" class="py-0">
                                <v-dialog v-model="dialog" persistent>
                                    <template v-slot:activator="{ on }">
                                        <v-btn v-on="on" block>
                                            <span class="mr-2">Add Book</span>
                                            <v-icon>mdi-plus</v-icon>
                                        </v-btn>
                                    </template>
                                    <v-card>
                                        <v-card-title class="headline"
                                            >Add Book</v-card-title
                                        >
                                        <v-card-text>
                                            <v-form v-model="valid">
                                                <v-container>
                                                    <v-row>
                                                        <v-col cols="12">
                                                            <v-text-field
                                                                v-model="
                                                                    firstname
                                                                "
                                                                :rules="
                                                                    nameRules
                                                                "
                                                                :counter="10"
                                                                label="First name"
                                                                required
                                                            ></v-text-field>
                                                        </v-col>

                                                        <v-col cols="12">
                                                            <v-text-field
                                                                v-model="
                                                                    lastname
                                                                "
                                                                :rules="
                                                                    nameRules
                                                                "
                                                                :counter="10"
                                                                label="Last name"
                                                                required
                                                            ></v-text-field>
                                                        </v-col>
                                                    </v-row>
                                                </v-container>
                                            </v-form>
                                        </v-card-text>
                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn
                                                color="green darken-1"
                                                text
                                                @click="dialog = false"
                                                >Cancel</v-btn
                                            >
                                            <v-btn
                                                color="green darken-1"
                                                text
                                                dark
                                                @click="dialog = false"
                                                >Add</v-btn
                                            >
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
                            </v-col>
                            <v-col cols="6" class="py-0">
                                <v-menu offset-y>
                                    <template v-slot:activator="{ on }">
                                        <v-btn v-on="on" block>
                                            <span class="mr-2">Export</span>
                                            <v-icon>mdi-chevron-down</v-icon>
                                        </v-btn>
                                    </template>
                                    <v-list>
                                        <v-list-item
                                            v-for="(item, index) in [
                                                { title: 'Click Me' },
                                                { title: 'Click Me' },
                                                { title: 'Click Me' }
                                            ]"
                                            :key="index"
                                            @click="() => {}"
                                        >
                                            <v-list-item-title>{{
                                                item.title
                                            }}</v-list-item-title>
                                        </v-list-item>
                                    </v-list>
                                </v-menu>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
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
                            <template v-slot:item.actions="{ item }">
                                <v-icon small @click="() => {}">
                                    mdi-delete
                                </v-icon>
                            </template>
                        </v-data-table>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-app>
</template>

<script>
import HelloWorld from "./components/HelloWorld";

export default {
    name: "App",

    components: {
        HelloWorld
    },

    data: () => ({
        dialog: false,
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
