 <!-- Loan Applications Table - SCROLLABLE -->
            <div class="mb-24">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Riwayat Ajuan</h2>
                
                <!-- Table with horizontal scroll -->
                <div class="bg-white rounded-xl shadow overflow-x-scroll">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No.
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jenis Ajuan
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nominal
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($pinjaman as $item): ?>
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo $item['no']; ?>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo $item['tanggal']; ?>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo $item['jenis']; ?>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo $item['nominal']; ?>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        <?php
                                        if ($item['status'] == 'Diterima') {
                                            echo 'bg-green-100 text-green-800';
                                        } elseif ($item['status'] == 'Ditolak') {
                                            echo 'bg-red-100 text-red-800';
                                        } else {
                                            echo 'bg-yellow-100 text-yellow-800';
                                        }
                                        ?>">
                                        <?php echo $item['status']; ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>