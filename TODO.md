# TODO: Implement Edit Button for Pengembalian with 30-Minute Lock

## Steps to Complete

1. **Modify PengembalianController edit method**: Add check to allow edit only within 30 minutes of creation. If not, redirect with error message. ✅ Completed

2. **Modify PengembalianController update method**: Add check to allow update only within 30 minutes of creation. If not, redirect with error message. ✅ Completed

3. **Update index.blade.php view**: Add edit button in the actions column, but only display if the pengembalian was created within the last 30 minutes. ✅ Completed

4. **Test the functionality**: Ensure edit button appears only for recent pengembalians, and editing is blocked after 30 minutes.
