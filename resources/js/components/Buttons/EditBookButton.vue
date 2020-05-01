<template>
    <v-dialog v-model="dialog" persistent>
        <template v-slot:activator="{ on }">
            <v-icon small v-on="on">
                mdi-pencil
            </v-icon>
        </template>
        <v-card>
            <v-card-title class="headline">Edit Book</v-card-title>
            <v-card-text>
                <BookForm :book="formBook" ref="form" />
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="green darken-1" text @click="dialog = false"
                    >Cancel</v-btn
                >
                <v-btn color="green darken-1" dark @click="submitForm"
                    >Update</v-btn
                >
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import BookForm from "../Forms/BookForm.vue";
export default {
    name: "EditBookButton",
    components: {
        BookForm
    },
    props: ["book"],
    data: function() {
        return {
            dialog: false,
            formBook: {
                title: this.book.title,
                author: {
                    name: `${this.book.author.givenName} ${this.book.author.familyName}`
                }
            }
        };
    },
    methods: {
        submitForm: function() {
            if (!this.$refs.form.valid) return;
            this.$store.dispatch("updateBook", {
                id: this.book.id,
                book: this.formBook
            });
            this.dialog = false;
        }
    }
};
</script>
