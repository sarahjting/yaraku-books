<template>
    <v-dialog v-model="dialog" max-width="290">
        <template v-slot:activator="{ on }">
            <v-btn v-on="on" block>
                <span class="mr-2">Export</span>
                <v-icon>mdi-save</v-icon>
            </v-btn>
        </template>
        <v-card>
            <v-card-title class="headline">Export Books</v-card-title>
            <v-card-text>
                <v-form v-model="valid">
                    <v-row>
                        <v-col cols="12" class="pb-0">
                            <v-select
                                :items="availableFormats"
                                v-model="format"
                                label="Format"
                            ></v-select>
                        </v-col>
                        <v-col cols="12" class="py-0">
                            <v-row justify="space-around" class="text-left">
                                <v-checkbox
                                    v-for="(v, k) in availableFields"
                                    :key="k"
                                    :label="v"
                                    v-model="fields[k]"
                                    :rules="validationRules.fields"
                                ></v-checkbox>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="green"
                    block
                    raised
                    :dark="!!valid"
                    :disabled="!valid"
                    :href="downloadLink"
                    :download="downloadFileName"
                    >Export</v-btn
                >
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: "ExportButton",
    data: () => ({
        valid: true,
        availableFormats: ["XML", "CSV"],
        availableFields: {
            title: "Title",
            "author.name": "Author"
        },
        dialog: false,
        format: "XML",
        fields: {
            title: true,
            "author.name": true
        }
    }),
    computed: {
        selectedFields: function() {
            return Object.keys(this.availableFields).filter(
                x => this.fields[x]
            );
        },
        downloadLink: function() {
            if (!this.valid) return "#";
            const fields = this.selectedFields.join(",");
            return `/export/books?format=${this.format}&fields=${fields}`;
        },
        downloadFileName: function() {
            return "yaraku-books." + this.format.toLowerCase();
        },
        validationRules: function() {
            return {
                fields: [
                    this.selectedFields.length >= 1 ||
                        "Must select at least one field."
                ]
            };
        }
    }
};
</script>
