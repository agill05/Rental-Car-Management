# TODO: Enhancements to Rental and Return Features

## 1. Automatic Fine Calculation on Return
- Add logic in PengembalianController::store to calculate denda based on overdue days (e.g., 50000 per day).
- Use Carbon to calculate days between tanggal_kembali_rencana and tanggal_kembali_aktual.

## 2. Automatic Check for Overdue Rentals
- Add 'terlambat' to peminjaman status enum.
- Add method to Peminjaman model: isOverdue() and calculateFine().
- Create a command to check and update overdue rentals periodically (php artisan make:command CheckOverdueRentals).
- Run this command via scheduler.

## 3. Additional Validation on Rentals
- In PeminjamanController::store and UserRentalController::storeRental, add validation to check if mobil and supir are available on the rental dates (prevent overlapping bookings).
- Add scope or method to check availability.

## 4. Payment History
- Add migration to add 'status_pembayaran' column to pengembalian table (enum: belum_bayar, sudah_bayar).
- Update Pengembalian model fillable.
- Update PengembalianController to set status_pembayaran on create/update.

## 5. Car Condition Assessment
- Add migration to add 'biaya_kerusakan' column to pengembalian table (decimal).
- Update Pengembalian model fillable.
- Update PengembalianController to include biaya_kerusakan in total_bayar_akhir calculation.
- Update views to display/input biaya_kerusakan.

## Implementation Steps
- [ ] Create migration for pengembalian table additions.
- [ ] Update peminjaman status enum migration.
- [ ] Update Peminjaman model with new methods.
- [ ] Update Pengembalian model.
- [ ] Update PengembalianController for auto denda and new fields.
- [ ] Update PeminjamanController for validation.
- [ ] Update UserRentalController for validation.
- [ ] Create CheckOverdueRentals command.
- [ ] Update views if necessary.
- [ ] Test the changes.
