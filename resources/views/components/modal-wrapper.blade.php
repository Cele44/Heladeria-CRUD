<div 
  x-data="{ showModal: false, content: '' }" 
  x-show="showModal"
  x-cloak
  @open-modal.window="fetch($event.detail.url)
    .then(res => res.text())
    .then(html => {
        content = html;
        showModal = true;
    })
    .catch(err => { console.error(err); content = '<p class=\'text-red-500\'>Error cargando modal.</p>'; showModal = true; })"
  @close-modal.window="showModal = false"
  @click.self="showModal = false"
  class="fixed inset-0 flex items-center justify-center bg-black/50 backdrop-blur-md z-40"
>
  <div class="bg-white w-11/12 md:w-1/2 p-6 rounded-lg shadow-lg relative max-h-[90vh] overflow-y-auto">
    <button class="absolute top-2 right-3 text-red-500 text-xl" @click="showModal = false">✖</button>
    <div x-html="content"></div>
  </div>
</div>
