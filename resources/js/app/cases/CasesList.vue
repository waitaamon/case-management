<template>
    <div>
        <div class="grid grid-cols-4 gap-2">

            <div class="col-span-4 flex justify-end space-x-3">

                <case-modal :investigators="investigators"
                            :public-sectors="publicSectors"
                            @fetch-cases="fetchCases" v-if="$user.role === 'agency-admin'"></case-modal>
                <case-show-modal :judiciary-officers="judiciaryOfficers" ref="caseShowModal"/>
            </div>
        </div>
        <div class="mt-3">
            <div class="overflow-hidden border-b border-gray-200 sm:rounded">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>

                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Public Sector Institution
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Title
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Investigator
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Judicial Officer
                        </th>
                        <th scope="col"
                            class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col"
                            class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Is Published
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="record in cases" :key="record.id">

                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 capitalize">
                            {{ record.public_sector_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 capitalize">
                            {{ record.title }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 capitalize">
                            {{ record.investigator_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                            {{ record.judicial_officer_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                            {{ record.status }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500 capitalize">
                            {{ record.is_published ? 'published' : 'not published' }}
                        </td>
                        <td class="flex space-x-3 justify-center px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a @click.prevent="viewCase(record)" href="#"
                               class="text-gray-600 hover:text-indigo-900">view</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import CaseModal from "./partials/CaseModal";
import CaseShowModal from "./partials/CaseShowModal";

export default {
    name: 'legal-cases-list',

    components: {
        CaseShowModal,
        CaseModal,
    },
    data() {
        return {
            cases: [],
            investigators: [],
            publicSectors: [],
            judiciaryOfficers: [],
            role: 'agency-admin'
        }
    },

    methods: {

        async prerequisites() {
            try {
                let response = await axios.get('/api/cases-prerequisites')

                this.investigators = response.data.investigators
                this.publicSectors = response.data.public_sectors
                this.judiciaryOfficers = response.data.judiciary_officers
                this.role = response.data.role

            } catch (e) {
                this.$toasted.error('Something went wrong try again later');
            }
        },

        viewCase(legalCase) {
            this.$refs.caseShowModal.legalCase = legalCase
            this.$refs.caseShowModal.showModal = true
        },

        async fetchCases() {
            try {
                let response = await axios.get(`/api/legal-cases`)

                this.cases = response.data
            } catch (e) {
                this.$toasted.error('Something went wrong, try again later');
            }
        }
    },
    created() {
        this.prerequisites()
        this.fetchCases()
    }
}
</script>