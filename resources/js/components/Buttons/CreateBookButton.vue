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
                <v-form v-model="valid">
                    <v-container>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="book.title"
                                    :rules="validationRules.title"
                                    label="Title"
                                    required
                                ></v-text-field>
                            </v-col>

                            <v-col cols="12">
                                <v-text-field
                                    v-model="book.author.name"
                                    :rules="validationRules.author"
                                    label="Author"
                                    required
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="green darken-1" text @click="dialog = false"
                    >Cancel</v-btn
                >
                <v-btn color="green darken-1" text dark @click="dialog = false"
                    >Add</v-btn
                >
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: "CreateBookButton",
    data: () => ({
        dialog: false,
        valid: false,
        book: {
            title: "",
            author: {
                name: ""
            }
        },
        validationRules: {
            author: [
                v => !!v || "Author is required",
                v =>
                    v.split(" ").length > 1 || "Must have given and family name"
            ],
            title: [v => !!v || "Title is required"]
        }
    })
};
</script>
