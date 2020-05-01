<template>
    <v-dialog v-model="dialog" persistent>
        <template v-slot:activator="{ on }">
            <v-btn v-on="on" block>
                <span class="mr-2">Add Book</span>
                <v-icon>mdi-plus</v-icon>
            </v-btn>
        </template>
        <v-card>
            <v-card-title class="headline">Add Book</v-card-title>
            <v-card-text>
                <BookForm :book="book" ref="form" />
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="green darken-1" text @click="dialog = false"
                    >Cancel</v-btn
                >
                <v-btn color="green darken-1" dark @click="submitForm"
                    >Add</v-btn
                >
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import BookForm from "../Forms/BookForm.vue";
export default {
    name: "CreateBookButton",
    components: {
        BookForm
    },
    data: () => ({
        dialog: false,
        book: {
            title: "",
            author: {
                name: ""
            }
        }
    }),
    methods: {
        submitForm: function() {
            if (!this.$refs.form.valid) return;
            this.$store.dispatch("createBook", this.book);
            this.dialog = false;
        }
    }
};
</script>
