# Complaint Management System

## Local Hosting

1. Run the Apache server and MySQL.
2. Create a database called `final` and import the `final.sql` file.
3. Access the system at `http://localhost/ComplainManagementSystem/ComplaintMS/login.php`.

## Login

For remote access through the server, visit: `http://10.10.10.157/group10/ComplaintManagementSystem-DCS/Project`

**Username:** MAIN_ADMIN  
**Password:** 12345

## New Modifications

### Master Admin

- **New User Role**: Created a new user role named "Authority (Staff)".
- **User Management**:
  - Main admin can create, delete, and deactivate users.
  - Master admin can create new user accounts.
- **Admin Categories**:
  - Defined specific roles including Head of Department, Lecturer, Network Manager, Instructors, Technical Officer, Laboratory Attendant, Staff Management Assistant, etc.
- **Student User Creation**: Master admin can create student accounts.
- **Complaint Type Association**:
  - Added complaint types relevant to specific admin roles.
  - For example, complaints relevant to HODs are marked with Supervisor Type.
- **Location Tracking**:
  - Added a location field to specify where the issue occurred within DCS premises.

### Staff User

- **New User Role**: Created a "Staff" user role.
- **Complaint Submission**:
  - Staff can submit complaints and view a dashboard similar to the master admin's dashboard, showing total, resolved, and unresolved complaints.
  - **New Complaint Fields**:
    - **Serial Number**: Staff can add an inventory serial number for filtering items or checking warranty periods.
    - **Location**: Specifies the location associated with the complaint, helping to identify damaged products.
    - **Type**: Select complaint categories relevant to the admin type, facilitating quicker identification and resolution.
    - **Date**: Displays the date the complaint was lodged.
    - **Image Upload**: Staff can upload images of the damaged product or issue.
- **Complaint Records**: Staff users can view all complaint records.

### Student User

- **Custom Home Page**:
  - Each student has a personalized home page. If they have ongoing complaints, they can view the status; if no complaints are pending, the page displays "No unresolved complaints found."
- **Complaint History**: Students can view their complaint history in the "Your Complaints" section.
- **Complaint Status**: View complaint status, details, and types.
- **About Section**: An "About" navigation bar guides new student users on how to use the complaint system.
- **Profile Enhancements**:
  - The profile navigation bar now correctly loads profile-related data.
  - Students can add a profile picture.
- **Complaint Submission**:
  - Students can lodge complaints via the "Complaint" navigation bar.
  - **New Complaint Fields**:
    - **Image Upload**: Students can upload an image of the damaged product or issue.
    - **Serial Number**: Option to add a serial number, aiding in filtering items and checking warranty status.
    - **Location**: Specify the location to identify the damaged product.
    - **Type**: Select complaint categories relevant to admin type for efficient issue management.
    - **Date**: Displays the complaint’s lodged date.
    - **Update**: Student can update their current complain and also vote (like up vote) the complains
    - **Password**: If an user forgot their password they can reset their password via clicking forgot password button, It will send OTP to their respective email to reset it

---
