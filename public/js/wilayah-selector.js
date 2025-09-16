// Indonesian Regional Address Selector
window.WilayahSelector = {
    init(options = {}) {
        // options: { prefix, ids: {provinsi,kabupaten,kecamatan,kelurahan,detail,preview,hidden}, preselect: {provinsi_id,...} }
        const ids = options.ids || {};
        this.provinsiSelect = document.getElementById(ids.provinsi || 'provinsi_id');
        this.kabupatenSelect = document.getElementById(ids.kabupaten || 'kabupaten_id');
        this.kecamatanSelect = document.getElementById(ids.kecamatan || 'kecamatan_id');
        this.kelurahanSelect = document.getElementById(ids.kelurahan || 'kelurahan_id');
        this.detailField = document.getElementById(ids.detail || 'alamat_detail');
        this.alamatPreview = document.getElementById(ids.preview || 'alamat_preview');
        this.hiddenAlamat = document.getElementById(ids.hidden || 'alamat');
        this.preselect = options.preselect || {};
        this.composeMode = options.composeMode !== false; // allow disabling hidden alamat composition
    this.cacheTTL = options.cacheTTL || 3600 * 1000; // 1 hour default
    this.cachePrefix = 'wilayah_cache_v1_';

    this.attachDetailListener();

        if (!this.provinsiSelect) return; // nothing to do

        this.bindEvents();
        this.loadProvinsi().then(()=>{
            // Chain load if preselect provided
            if (this.preselect.provinsi_id) {
                this.provinsiSelect.value = this.preselect.provinsi_id;
                this.onProvinsiChange(this.preselect.provinsi_id, true);
            }
        });
    },

    bindEvents() {
        if (this.provinsiSelect) {
            this.provinsiSelect.addEventListener('change', (e) => {
                this.onProvinsiChange(e.target.value);
            });
        }

        if (this.kabupatenSelect) {
            this.kabupatenSelect.addEventListener('change', (e) => {
                this.onKabupatenChange(e.target.value);
            });
        }

        if (this.kecamatanSelect) {
            this.kecamatanSelect.addEventListener('change', (e) => {
                this.onKecamatanChange(e.target.value);
            });
        }

        if (this.kelurahanSelect) {
            this.kelurahanSelect.addEventListener('change', (e) => {
                this.onKelurahanChange(e.target.value);
            });
        }
    },

    async loadProvinsi() {
        try {
            const cached = this.getCache('provinsi');
            if (cached) {
                this.populateSelect(this.provinsiSelect, cached, 'Pilih Provinsi');
                return;
            }
            const response = await fetch('/api/wilayah/provinsi');
            const result = await response.json();
            if (result.success) {
                this.setCache('provinsi', result.data);
                this.populateSelect(this.provinsiSelect, result.data, 'Pilih Provinsi');
            } else {
                this.showError(this.provinsiSelect, 'Gagal memuat provinsi');
            }
        } catch (error) {
            console.error('Error loading provinces:', error);
            this.showError(this.provinsiSelect, 'Error jaringan');
        }
    },

    async onProvinsiChange(provinsiId, fromPreselect = false) {
        this.clearSelect(this.kabupatenSelect, 'Pilih Kabupaten/Kota');
        this.clearSelect(this.kecamatanSelect, 'Pilih Kecamatan');
        this.clearSelect(this.kelurahanSelect, 'Pilih Kelurahan');
        this.updateAlamatPreview();

        if (!provinsiId) return;

        try {
            const cacheKey = `kabupaten_${provinsiId}`;
            let data = this.getCache(cacheKey);
            if (!data) {
                const response = await fetch(`/api/wilayah/kabupaten?provinsi_id=${provinsiId}`);
                const result = await response.json();
                if (result.success) {
                    data = result.data;
                    this.setCache(cacheKey, data);
                } else {
                    this.showError(this.kabupatenSelect, 'Gagal memuat kabupaten');
                    return; 
                }
            }
            this.populateSelect(this.kabupatenSelect, data, 'Pilih Kabupaten/Kota', (item) => `${item.type} ${item.name}`);
            if (fromPreselect && this.preselect.kabupaten_id) {
                this.kabupatenSelect.value = this.preselect.kabupaten_id;
                await this.onKabupatenChange(this.preselect.kabupaten_id, true);
            }
        } catch (error) {
            console.error('Error loading regencies:', error);
            this.showError(this.kabupatenSelect, 'Error jaringan');
        }
    },

    async onKabupatenChange(kabupatenId, fromPreselect = false) {
        this.clearSelect(this.kecamatanSelect, 'Pilih Kecamatan');
        this.clearSelect(this.kelurahanSelect, 'Pilih Kelurahan');
        this.updateAlamatPreview();

        if (!kabupatenId) return;

        try {
            const cacheKey = `kecamatan_${kabupatenId}`;
            let data = this.getCache(cacheKey);
            if (!data) {
                const response = await fetch(`/api/wilayah/kecamatan?kabupaten_id=${kabupatenId}`);
                const result = await response.json();
                if (result.success) {
                    data = result.data;
                    this.setCache(cacheKey, data);
                } else {
                    this.showError(this.kecamatanSelect, 'Gagal memuat kecamatan');
                    return; 
                }
            }
            this.populateSelect(this.kecamatanSelect, data, 'Pilih Kecamatan');
            if (fromPreselect && this.preselect.kecamatan_id) {
                this.kecamatanSelect.value = this.preselect.kecamatan_id;
                await this.onKecamatanChange(this.preselect.kecamatan_id, true);
            }
        } catch (error) {
            console.error('Error loading districts:', error);
            this.showError(this.kecamatanSelect, 'Error jaringan');
        }
    },

    async onKecamatanChange(kecamatanId, fromPreselect = false) {
        this.clearSelect(this.kelurahanSelect, 'Pilih Kelurahan');
        this.updateAlamatPreview();

        if (!kecamatanId) return;

        try {
            const cacheKey = `kelurahan_${kecamatanId}`;
            let data = this.getCache(cacheKey);
            if (!data) {
                const response = await fetch(`/api/wilayah/kelurahan?kecamatan_id=${kecamatanId}`);
                const result = await response.json();
                if (result.success) {
                    data = result.data;
                    this.setCache(cacheKey, data);
                } else {
                    this.showError(this.kelurahanSelect, 'Gagal memuat kelurahan');
                    return; 
                }
            }
            this.populateSelect(this.kelurahanSelect, data, 'Pilih Kelurahan');
            if (fromPreselect && this.preselect.kelurahan_id) {
                this.kelurahanSelect.value = this.preselect.kelurahan_id;
                await this.onKelurahanChange(this.preselect.kelurahan_id, true);
            }
        } catch (error) {
            console.error('Error loading villages:', error);
            this.showError(this.kelurahanSelect, 'Error jaringan');
        }
    },

    async onKelurahanChange(kelurahanId) {
        this.updateAlamatPreview();

        if (!kelurahanId) return;

        try {
            const response = await fetch(`/api/wilayah/alamat-lengkap?kelurahan_id=${kelurahanId}`);
            const result = await response.json();
            
            if (result.success) {
                this.updateAlamatPreview(result.data);
            }
        } catch (error) {
            console.error('Error loading complete address:', error);
            this.showError(this.kelurahanSelect, 'Gagal detail');
        }
    },

    populateSelect(selectElement, data, placeholder, formatter = null) {
        if (!selectElement) return;

        selectElement.innerHTML = `<option value="">${placeholder}</option>`;
        
        data.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = formatter ? formatter(item) : item.name;
            selectElement.appendChild(option);
        });

        selectElement.disabled = false;
    },

    clearSelect(selectElement, placeholder) {
        if (!selectElement) return;

        selectElement.innerHTML = `<option value="">${placeholder}</option>`;
        selectElement.disabled = true;
    },

    updateAlamatPreview(data = null) {
        if (!this.alamatPreview) return;

        if (data) {
            this.alamatPreview.innerHTML = `
                <div class="bg-green-50 border border-green-200 rounded-lg p-3 text-sm">
                    <div class="font-medium text-green-800 mb-1">Alamat Lengkap:</div>
                    <div class="text-green-700">${data.alamat_formatted}</div>
                    <div class="text-green-600 text-xs mt-1">Kode Pos: ${data.kode_pos}</div>
                </div>
            `;

            // Also update hidden alamat field if exists
            if (this.composeMode && this.hiddenAlamat) {
                const detailText = this.detailField ? this.detailField.value.trim() : '';
                this.hiddenAlamat.value = detailText
                    ? `${detailText}, ${data.alamat_formatted} Kode Pos: ${data.kode_pos}`
                    : `${data.alamat_formatted} Kode Pos: ${data.kode_pos}`;
            }
        } else {
            this.alamatPreview.innerHTML = '';
        }
    }
    ,
    // Caching helpers
    setCache(key, data) {
        try {
            const payload = { t: Date.now(), d: data };
            sessionStorage.setItem(this.cachePrefix + key, JSON.stringify(payload));
        } catch(e){ /* ignore quota */ }
    },
    getCache(key) {
        try {
            const raw = sessionStorage.getItem(this.cachePrefix + key);
            if(!raw) return null;
            const payload = JSON.parse(raw);
            if(Date.now() - payload.t > this.cacheTTL) {
                sessionStorage.removeItem(this.cachePrefix + key);
                return null;
            }
            return payload.d;
        } catch(e){ return null; }
    },
    showError(selectEl, msg) {
        if(!selectEl) return;
        this.clearError(selectEl);
        const badge = document.createElement('div');
        badge.className = 'mt-1 text-xs text-red-600 font-medium error-badge';
        badge.textContent = msg;
        selectEl.parentElement.appendChild(badge);
    },
    clearError(selectEl){
        if(!selectEl) return;
        const existing = selectEl.parentElement.querySelector('.error-badge');
        if(existing) existing.remove();
    },
    attachDetailListener(){
        if(this.detailField && this.composeMode){
            this.detailField.addEventListener('input', ()=>{
                // If alamat preview already has data (hiddenAlamat set) recompute quickly by re-calling onKelurahanChange
                if(this.kelurahanSelect && this.kelurahanSelect.value){
                    this.onKelurahanChange(this.kelurahanSelect.value);
                } else {
                    // Just update hidden with detail only
                    if(this.hiddenAlamat){ this.hiddenAlamat.value = this.detailField.value.trim(); }
                }
            });
        }
    }
};

// Auto initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('#provinsi_id')) {
        WilayahSelector.init();
    }
});

// Alpine.js data function for integration
window.wilayahData = function() {
    return {
        alamatLengkap: '',
        
        init() {
            // Initialize the wilayah selector
            if (typeof WilayahSelector !== 'undefined') {
                WilayahSelector.init();
            }
        }
    }
};
