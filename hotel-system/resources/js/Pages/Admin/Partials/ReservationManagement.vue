<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    reservations: Array,
});

const statusColors = {
    pending:   'bg-amber-100 text-amber-800',
    confirmed: 'bg-emerald-100 text-emerald-800',
    cancelled: 'bg-red-100 text-red-700',
};

const roomLabels = {
    standard: 'Standard Room',
    deluxe:   'Deluxe Room',
    suite:    'Premium Suite',
    villa:    'Private Villa',
};

const formatDate = (dateStr) => {
    if (!dateStr) return '—';
    return new Date(dateStr).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
};

const changeStatus = (id, status) => {
    router.put(`/admin/reservations/${id}/status`, { status }, { preserveScroll: true });
};

const deleteReservation = (id) => {
    if (confirm('Are you sure you want to delete this reservation?')) {
        router.delete(`/admin/reservations/${id}`, { preserveScroll: true });
    }
};

// Expanded row
const expandedId = ref(null);
const toggle = (id) => {
    expandedId.value = expandedId.value === id ? null : id;
};
</script>

<template>
    <div>
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-extrabold text-[#001a2c]">Reservations</h2>
                <p class="text-gray-400 text-sm mt-1">{{ reservations.length }} total booking{{ reservations.length !== 1 ? 's' : '' }}</p>
            </div>
            <!-- Stats -->
            <div class="flex gap-4">
                <div class="stat-card">
                    <span class="stat-num text-amber-600">{{ reservations.filter(r => r.status === 'pending').length }}</span>
                    <span class="stat-label">Pending</span>
                </div>
                <div class="stat-card">
                    <span class="stat-num text-emerald-600">{{ reservations.filter(r => r.status === 'confirmed').length }}</span>
                    <span class="stat-label">Confirmed</span>
                </div>
                <div class="stat-card">
                    <span class="stat-num text-red-500">{{ reservations.filter(r => r.status === 'cancelled').length }}</span>
                    <span class="stat-label">Cancelled</span>
                </div>
            </div>
        </div>

        <!-- Empty state -->
        <div v-if="!reservations.length" class="text-center py-20 text-gray-400">
            <p class="text-5xl mb-4">📭</p>
            <p class="font-bold">No reservations yet</p>
            <p class="text-sm">Bookings from your website will appear here.</p>
        </div>

        <!-- Table -->
        <div v-else class="overflow-hidden rounded-xl border border-gray-100">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left text-gray-400 text-xs uppercase tracking-wider">
                        <th class="px-5 py-3 font-bold">Guest</th>
                        <th class="px-5 py-3 font-bold">Check-in</th>
                        <th class="px-5 py-3 font-bold">Check-out</th>
                        <th class="px-5 py-3 font-bold">Room</th>
                        <th class="px-5 py-3 font-bold">Status</th>
                        <th class="px-5 py-3 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="res in reservations" :key="res.id">
                        <!-- Main row -->
                        <tr class="border-t border-gray-50 hover:bg-gray-50/50 transition-colors cursor-pointer"
                            @click="toggle(res.id)">
                            <td class="px-5 py-4">
                                <p class="font-bold text-[#001a2c]">{{ res.first_name }} {{ res.last_name }}</p>
                                <p class="text-xs text-gray-400">{{ res.email }}</p>
                            </td>
                            <td class="px-5 py-4 text-gray-600">{{ formatDate(res.check_in) }}</td>
                            <td class="px-5 py-4 text-gray-600">{{ formatDate(res.check_out) }}</td>
                            <td class="px-5 py-4 text-gray-600">{{ roomLabels[res.room_type] || res.room_type }}</td>
                            <td class="px-5 py-4">
                                <span class="status-badge" :class="statusColors[res.status]">
                                    {{ res.status }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right" @click.stop>
                                <div class="flex gap-2 justify-end">
                                    <button v-if="res.status !== 'confirmed'" @click="changeStatus(res.id, 'confirmed')"
                                            class="action-btn text-emerald-600 hover:bg-emerald-50" title="Confirm">
                                        ✓
                                    </button>
                                    <button v-if="res.status !== 'cancelled'" @click="changeStatus(res.id, 'cancelled')"
                                            class="action-btn text-red-500 hover:bg-red-50" title="Cancel">
                                        ✕
                                    </button>
                                    <button @click="deleteReservation(res.id)"
                                            class="action-btn text-gray-400 hover:bg-gray-100" title="Delete">
                                        🗑
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Expanded detail row -->
                        <tr v-if="expandedId === res.id" class="bg-gray-50/80">
                            <td colspan="6" class="px-5 py-5">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-sm">
                                    <div>
                                        <span class="detail-label">Phone</span>
                                        <p class="detail-value">{{ res.phone }}</p>
                                    </div>
                                    <div>
                                        <span class="detail-label">Country</span>
                                        <p class="detail-value">{{ res.country }}</p>
                                    </div>
                                    <div>
                                        <span class="detail-label">Guests</span>
                                        <p class="detail-value">{{ res.adults }} adults, {{ res.children }} children</p>
                                    </div>
                                    <div>
                                        <span class="detail-label">Package</span>
                                        <p class="detail-value">{{ res.package ? res.package.name : 'None' }}</p>
                                    </div>
                                    <div v-if="res.special_requests" class="col-span-2 md:col-span-4">
                                        <span class="detail-label">Special Requests</span>
                                        <p class="detail-value">{{ res.special_requests }}</p>
                                    </div>
                                    <div>
                                        <span class="detail-label">Booked on</span>
                                        <p class="detail-value">{{ formatDate(res.created_at) }}</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>
.stat-card {
    @apply flex flex-col items-center bg-gray-50 rounded-xl px-5 py-3 min-w-[80px];
}
.stat-num {
    @apply text-xl font-black;
}
.stat-label {
    @apply text-[10px] text-gray-400 uppercase tracking-widest font-bold mt-1;
}

.status-badge {
    @apply inline-block px-3 py-1 rounded-full text-xs font-bold capitalize;
}

.action-btn {
    @apply w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold transition-colors;
}

.detail-label {
    @apply block text-xs text-gray-400 uppercase tracking-wider font-bold mb-1;
}
.detail-value {
    @apply text-[#001a2c] font-semibold;
}
</style>
