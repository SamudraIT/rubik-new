<x-filament-panels::page>
  <div class="grid md:grid-cols-2 gap-4">
    <div class="relative overflow-x-auto">
      <div class="bg-orange-400 p-2 rounded-t-lg">
        <h4 class="text-sm font-semibold">Tabel Berjenjang Kasus DBD</h4>
      </div>
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">
              Kecamatan
            </th>
            <th scope="col" class="px-6 py-3">
              Kelurahan

            </th>
            <th scope="col" class="px-6 py-3">
              RW
            </th>
          </tr>
        </thead>
        <tbody>
          {{-- admin/pencatatan-jentiks?tableFilters[master_kecamatan_id][value]=1&tableFilters[master_kelurahan_id][value]=1 --}}
          @foreach($this->getDataJentik() as $data)
          <tr onclick="" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              {{ $data->kecamatan->nama }}
            </th>
            <td class="px-6 py-4">
              {{ $data->kelurahan->nama }}
            </td>
            <td class="px-6 py-4">
              {{ $data->rw }} ({{ $data['count'] }})
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="relative overflow-x-auto">
      <div class="bg-orange-400 p-2 rounded-t-lg">
        <h4 class="text-sm font-semibold">Tabel Berjenjang Pencatatan Jentik</h4>
      </div>
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">
              Kecamatan

            </th>
            <th scope="col" class="px-6 py-3">
              Kelurahan

            </th>
            <th scope="col" class="px-6 py-3">
              RW
            </th>
          </tr>

        </thead>
        <tbody>
          @foreach($this->getDataDbd() as $data)
          <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              {{ $data->kecamatan->nama }}
            </th>
            <td class="px-6 py-4">
              {{ $data->kelurahan->nama }}
            </td>
            <td class="px-6 py-4">
              {{ $data->rw }} ({{ $data['count'] }})
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</x-filament-panels::page>
