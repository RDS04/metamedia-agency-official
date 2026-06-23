# [SYSTEM: UI/UX GENERATION INSTRUCTIONS]

**Context:** Generate a landing page UI based on the structural layout of "Auréa Solutions" but strictly applying the brand identity and color tokens of "Universitas Metamedia".

## 1. GLOBAL DESIGN TOKENS (Variables)

Berdasarkan ekstraksi warna dari logo sebelumnya, terapkan variabel warna berikut ke dalam sistem:

* **`--color-primary` (Royal Blue):** Warna biru tua pilar. Digunakan untuk dominasi background *Hero* dan *Footer/Contact*.
* **`--color-secondary` (Cyan Blue):** Warna biru muda pita logo. Digunakan untuk aksen grafis, gelombang (*wave divider*), dan elemen sekunder.
* **`--color-accent` (Crimson Red):** Warna merah api logo. Digunakan EKSKLUSIF untuk *Call-to-Action* (CTA) Button dan interaksi *hover* agar kontras maksimal.
* **`--color-surface` (Pure White):** Digunakan untuk background *section* tengah (Layanan & Visi) dan *card*.
* **`--color-text-main` (Bold Black/Dark Grey):** Digunakan untuk teks paragraf pada *surface* putih agar *legibility* tinggi.
* **`--color-text-light` (Pure White):** Digunakan untuk teks di atas background biru tua/muda.

---

## 2. LAYOUT ARCHITECTURE & COLOR INJECTION

Bangun struktur DOM dan styling CSS menggunakan panduan per *section* berikut:

### A. HEADER & NAVBAR SECTION

* **Layout:** `display: flex; justify-content: space-between; align-items: center;`
* **Position:** *Absolute* atau *Fixed* di atas *Hero section*.
* **Color Mapping:**
* **Background:** Transparan (menyatu dengan Hero).
* **Logo Text:** `--color-surface` (Putih).
* **Nav Links:** `--color-surface` (Putih).
* **Active Link Indicator:** Garis bawah (underline) menggunakan `--color-accent` (Merah).



### B. HERO SECTION (Top)

* **Layout:** 2-Kolom (`display: grid; grid-template-columns: 1fr 1fr;`). Sisi kiri teks, sisi kanan *Hero Image/Graphic*.
* **Shape/Divider:** Terapkan *curved bottom edge* (*wave divider* melengkung ke bawah).
* **Color & Style Mapping:**
* **Background:** Gunakan gradasi linier atau radial memadukan `--color-primary` (Biru Tua) dan sentuhan *glow* `--color-secondary` (Biru Muda) di area kanan.
* **Heading Text (H1) & Subheading:** `--color-surface` (Putih).
* **CTA Button ("Découvrez Nos Solutions"):** * **Background:** `--color-accent` (Merah).
* **Text:** Putih.
* **Border-radius:** `8px` (sedikit melengkung).
* **Hover State:** Merah lebih gelap (darken 10%) dengan *box-shadow*.


* **Image Graphic:** Pertahankan gaya *dashboard/hologram*, namun filter warna disesuaikan dengan dominasi *Cyan Blue*.



### C. SERVICES SECTION ("Nos Services")

* **Layout:** * *Container:* `flex-direction: column; align-items: center;`
* *Grid:* 3-Kolom (`grid-template-columns: repeat(3, 1fr); gap: 2rem;`).


* **Color & Style Mapping:**
* **Section Background:** `--color-surface` (Putih).
* **Section Title:** `--color-primary` (Biru Tua), dengan aksen garis/ornamen kecil menggunakan `--color-secondary` (Biru Muda).
* **Service Cards:**
* **Background:** Putih dengan efek *Neumorphism* atau *Soft Drop Shadow* (`box-shadow: 0 10px 30px rgba(0,0,0,0.05);`).
* **Icon:** Integrasikan ikon dengan sentuhan paduan `--color-primary` dan `--color-accent` (Merah) agar relevan dengan logo.
* **Card Title:** `--color-primary` (Biru Tua).
* **Card Text:** `--color-text-main` (Hitam/Abu-abu gelap).





### D. VISION SECTION ("Notre Vision")

* **Layout:** 2-Kolom (`grid-template-columns: 1fr 1fr;`). Teks di kiri, Gambar (Orang/Tim) di kanan.
* **Shape/Divider:** Terapkan *curved wave* di bagian atas dan bawah *section* ini untuk memisahkan dari blok putih murni.
* **Color & Style Mapping:**
* **Background:** Gradasi sangat lembut (*Very light Cyan*) atau `--color-surface` murni dengan elemen grafis `--color-secondary` ber-opacity rendah di *background*.
* **Title & Highlighted Text:** Gunakan `--color-primary` (Biru Tua). Kata-kata kunci tebalkan (*bold*).
* **Images:** Gunakan foto bernuansa profesional, hindari warna *clashing* (terlalu banyak hijau/kuning), pastikan foto memiliki *tone* yang sejuk (cool tone).



### E. CONTACT / FOOTER SECTION ("Contactez-Nous")

* **Layout:** 2-Kolom tidak simetris (Kolom kiri 40% teks/info, Kolom kanan 60% Form).
* **Shape/Divider:** Transisi *wave* dari atas, mengarah ke area yang rata di bagian bawah.
* **Color & Style Mapping:**
* **Background:** Gunakan `--color-primary` (Biru Tua) solid untuk kesan *grounded* dan formal di akhir halaman.
* **Text (Left Column):** `--color-surface` (Putih).
* **Form Container (Right Column):**
* **Background:** `--color-surface` (Putih) dengan *border-radius* `12px`.
* **Input Fields:** Border bawah abu-abu terang, teks input `--color-text-main` (Hitam).
* **Submit Button ("Envoyer"):** * *Opsi 1 (High Contrast):* `--color-accent` (Merah) dengan teks putih.
* *Opsi 2 (Harmonious):* `--color-primary` (Biru Tua) dengan teks putih, *hover* ke `--color-secondary` (Biru Muda).







## 3. RESPONSIVE BEHAVIOR DIRECTIVES

* **Tablet (< 992px):** Ubah layout kolom Hero dan Vision menjadi `flex-direction: column-reverse;`. Ubah Service grid menjadi 2-kolom.
* **Mobile (< 768px):** Ubah semua layout grid menjadi 1-kolom (`1fr`). Ratakan teks ke tengah (*text-align: center*). Ubah *wave divider* menjadi sudut melengkung sederhana agar tidak memakan ruang vertikal. Kurangi ukuran tipografi H1 dari `3.5rem` menjadi `2rem`.

# [END OF INSTRUCTIONS]