<template>
    <v-row>
        <v-col cols="12">
            <v-data-table
                :headers="tableHeaders"
                :items="tableBody"
                class="elevation-1"
                fixed-header
                mobile-breakpoint="0"
                disable-pagination
                hide-default-footer
            >
                <template v-slot:item.author="{ item }">
                    {{ item.author.givenName }} {{ item.author.familyName }}
                    <v-icon
                        small
                        class="ml-1"
                        @click="() => searchAuthor(item)"
                    >
                        mdi-magnify
                    </v-icon>
                </template>
                <template v-slot:item.actions="{ item }">
                    <EditBookButton :book="item" />
                    <DeleteBookButton :book="item" />
                </template>
            </v-data-table>
        </v-col>
    </v-row>
</template>

<script>
import DeleteBookButton from "./Buttons/DeleteBookButton.vue";
import EditBookButton from "./Buttons/EditBookButton.vue";

export default {
    name: "DataTable",

    components: { DeleteBookButton, EditBookButton },

    data: () => ({
        tableHeaders: [
            { text: "Title", value: "title" },
            {
                text: "Author",
                value: "author",
                sort: function(a, b) {
                    const [aSortable, bSortable] = [a, b].map(i =>
                        (i.familyName + "," + i.givenName).toLowerCase()
                    );
                    return aSortable > bSortable ? 1 : -1;
                }
            },
            {
                text: "Actions",
                value: "actions",
                sortable: false,
                align: "center"
            }
        ]
    }),

    computed: {
        tableBody: function() {
            let { filter, filterBy } = this.$store.state;
            filter = filter.toLowerCase();
            return this.$store.state.books.filter(x => {
                if (!filter) return true;
                if (filterBy === "Title") {
                    return (
                        x.title.substr(0, filter.length).toLowerCase() ===
                        filter
                    );
                } else {
                    return (
                        x.author.givenName
                            .substr(0, filter.length)
                            .toLowerCase() === filter ||
                        x.author.familyName
                            .substr(0, filter.length)
                            .toLowerCase() === filter ||
                        `${x.author.givenName} ${x.author.familyName}`
                            .substr(0, filter.length)
                            .toLowerCase() === filter
                    );
                }
            });
        }
    },

    methods: {
        searchAuthor: function(book) {
            this.$store.state.filter = book.author.givenName;
            this.$store.state.filterBy = `Author`;
        }
    }
};
</script>
