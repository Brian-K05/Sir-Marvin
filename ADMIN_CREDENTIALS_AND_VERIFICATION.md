# Admin Credentials & Functionality Verification Guide

## 🔐 Admin Login Credentials

**Email:** `marvnbuena@gmail.com`  
**Password:** `Admin@2024!Secure#`

**Important Notes:**
- These credentials are automatically reset on every deployment via the `AdminSeeder`
- The seeder uses `updateOrCreate`, so the password is always reset to the default
- **Change your password immediately after first login** using the Security page in the admin panel

---

## 📋 Complete Admin Panel Functionality Checklist

Use this checklist to verify all admin pages and functions work correctly on Render.

### ✅ Authentication & Access

- [ ] **Login Page** (`/login`)
  - Can access login page
  - Can log in with admin credentials
  - Redirects to admin dashboard after login
  - Logout button works

- [ ] **Session Management**
  - Session persists across page navigation
  - Session doesn't expire unexpectedly
  - Can access admin pages after login

---

### ✅ Dashboard (`/admin/dashboard`)

- [ ] **Page Loads**
  - Dashboard displays without errors
  - All statistics cards show correct data:
    - Total Submissions
    - Pending Initial Payments
    - In Progress Submissions
    - Awaiting Final Payment
    - Pending Payments
    - Total Services

- [ ] **Recent Submissions Table**
  - Displays recent submissions
  - Filter buttons work (All, Completed, Cancelled)
  - Can view submission details

- [ ] **Pending Payments Section**
  - Shows pending payments
  - Payment information displays correctly

---

### ✅ Submissions Management (`/admin/submissions`)

- [ ] **Submissions List** (`/admin/submissions`)
  - Page loads without errors
  - Displays all submissions in a table
  - Pagination works (if more than 20 submissions)
  - Can see submission details:
    - Service name
    - Client name/email
    - Status
    - Created date

- [ ] **View Submission** (`/admin/submissions/{id}`)
  - Can click on a submission to view details
  - All submission information displays:
    - Client details
    - Service information
    - Document uploads
    - Payment status
    - Submission status
    - Instructions/notes

- [ ] **Update Submission Status**
  - Status dropdown/buttons work
  - Can change status to:
    - `pending_initial`
    - `initial_approved`
    - `in_progress`
    - `awaiting_final`
    - `final_approved`
    - `completed`
    - `cancelled`
  - Status updates save correctly
  - Success message displays

- [ ] **Upload Corrected Document**
  - Can upload corrected document
  - File upload works
  - Document saves correctly
  - Client can download corrected document

---

### ✅ Payments Management (`/admin/payments`)

- [ ] **Payments List** (`/admin/payments`)
  - Page loads without errors
  - Displays all payments in a table
  - Shows payment details:
    - Submission reference
    - Payment type (initial/final)
    - Amount
    - Status
    - Reference number
    - Payment proof

- [ ] **View Payment** (`/admin/payments/{id}`)
  - Can view individual payment details
  - Payment proof image displays
  - All payment information shows correctly

- [ ] **Approve Payment**
  - Approve button works
  - Payment status changes to "approved"
  - Success message displays
  - Submission status updates accordingly

- [ ] **Reject Payment**
  - Reject button works
  - Payment status changes to "rejected"
  - Success message displays
  - Appropriate notifications sent

---

### ✅ Services Management (`/admin/services`)

- [ ] **Services List** (`/admin/services`)
  - Page loads without errors
  - Displays all services in a table
  - Shows service details:
    - Service name
    - Description
    - Price
    - Initial payment percentage
    - Active status

- [ ] **Create Service** (`/admin/services/create`)
  - Can access create service page
  - Form fields work:
    - Name field
    - Description field (textarea)
    - Price field (numeric)
    - Initial Payment Percentage field
    - Active checkbox
  - Form validation works
  - Can submit and create new service
  - Success message displays
  - Redirects to services list

- [ ] **Edit Service** (`/admin/services/{id}/edit`)
  - Can access edit page
  - Form pre-fills with existing data
  - Can update service information
  - Form validation works
  - Can save changes
  - Success message displays

- [ ] **Delete Service** (`/admin/services/{id}`)
  - Delete button works
  - Confirmation dialog appears
  - Service is deleted from database
  - Success message displays
  - Redirects to services list

---

### ✅ Feedbacks Management (`/admin/feedbacks`)

- [ ] **Feedbacks List** (`/admin/feedbacks`)
  - Page loads without errors
  - Displays all feedbacks in a table
  - Shows feedback details:
    - Submission reference
    - Client name/email
    - Rating (stars)
    - Comment
    - Status (pending/approved)
    - Created date

- [ ] **Approve Feedback**
  - Approve button works
  - Feedback status changes to "approved"
  - Success message displays
  - Feedback appears on public pages (if applicable)

- [ ] **Delete Feedback**
  - Delete button works
  - Confirmation dialog appears
  - Feedback is deleted from database
  - Success message displays

---

### ✅ Security & Settings (`/admin/password/change`)

- [ ] **Change Password Page**
  - Can access password change page
  - Form fields work:
    - Current password field
    - New password field
    - Confirm password field
  - Form validation works:
    - Current password must be correct
    - New password meets requirements
    - Passwords match
  - Can update password
  - Success message displays
  - Can log in with new password
  - Old password no longer works

---

### ✅ Navigation & UI

- [ ] **Sidebar Navigation**
  - All navigation links work:
    - Dashboard link
    - Submissions link
    - Services link
    - Feedbacks link
    - Security link
  - Active page is highlighted
  - Navigation is responsive (mobile-friendly)

- [ ] **Header**
  - Page title displays correctly
  - User information shows:
    - Admin name
    - Admin email

- [ ] **Logout**
  - Logout button works
  - Logs out successfully
  - Redirects to home page
  - Cannot access admin pages after logout

- [ ] **Responsive Design**
  - Admin panel works on desktop
  - Admin panel works on tablet
  - Admin panel works on mobile
  - Sidebar collapses on mobile

---

### ✅ Error Handling

- [ ] **404 Errors**
  - Invalid URLs show proper 404 page
  - No broken links

- [ ] **403 Errors**
  - Non-admin users cannot access admin pages
  - Proper redirect to login

- [ ] **500 Errors**
  - No server errors on any page
  - Error messages are user-friendly (if any)

---

## 🧪 Testing Procedure

### Step 1: Login
1. Go to `https://sir-marvin-app.onrender.com/login`
2. Enter admin credentials
3. Verify redirect to dashboard

### Step 2: Test Each Section
1. Navigate through each section using the sidebar
2. Test create/edit/delete operations
3. Verify data displays correctly
4. Check for any console errors (F12 → Console)

### Step 3: Test Forms
1. Fill out each form
2. Test validation (submit empty forms, invalid data)
3. Verify success messages
4. Check database updates

### Step 4: Test File Uploads
1. Upload documents/images
2. Verify files are saved
3. Verify files can be downloaded/viewed

### Step 5: Test Responsive Design
1. Resize browser window
2. Test on mobile device (or browser dev tools)
3. Verify all elements are accessible

---

## 🐛 Common Issues & Solutions

### Issue: Can't log in
**Solution:**
- Verify credentials are correct
- Check if seeder ran: The admin account is created automatically on deployment
- Clear browser cache and cookies
- Try incognito/private browsing mode

### Issue: Pages redirect to login
**Solution:**
- Check session configuration in `.env`
- Verify `SESSION_DRIVER=database` is set
- Ensure `sessions` table exists (migration should create it)
- Check browser console for errors

### Issue: Forms don't submit
**Solution:**
- Check browser console for JavaScript errors
- Verify CSRF token is present
- Check network tab for failed requests
- Verify route exists in `routes/web.php`

### Issue: File uploads don't work
**Solution:**
- Verify `storage` directory has write permissions
- Check `storage:link` was created
- Verify file size limits in PHP configuration
- Check `storage/app/public` directory exists

### Issue: Data doesn't display
**Solution:**
- Verify database connection
- Check if migrations ran successfully
- Verify seeders ran (admin account, services)
- Check Laravel logs for errors

---

## 📝 Notes

- All admin routes are protected by the `admin` middleware
- The admin guard uses the `admins` table
- Sessions are stored in the database (`sessions` table)
- The admin account is automatically created/reset on each deployment
- All admin views are in `resources/views/admin/`
- All admin controllers are in `app/Http/Controllers/Admin/`

---

## ✅ Verification Complete

Once you've checked all items above, your admin panel is fully functional!

If you encounter any issues, check:
1. Browser console (F12 → Console)
2. Network tab (F12 → Network)
3. Render deployment logs
4. Laravel logs (if accessible)

