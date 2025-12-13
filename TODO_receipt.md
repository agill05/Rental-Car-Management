# TODO: Implement Receipt for User Rentals

## Implementation Steps
- [x] Add route in routes/web.php for GET /user/kwitansi-penyewaan/{peminjaman} -> UserRentalController@tampilkanKwitansi
- [x] Add showReceipt method in UserRentalController.php to display receipt for a specific rental with authorization check
- [x] Create resources/views/user/rental_receipt.blade.php styled as a typical receipt (fixed width, monospace font, dotted lines, etc.)
- [x] Update resources/views/user/penyewaan_saya.blade.php to add "View Receipt" button for each rental
- [x] Test the receipt view for correct display and printing
