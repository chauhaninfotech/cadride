# Passenger CRUD API Documentation

This document provides information about the Passenger CRUD API endpoints.

## Base URL
```
http://your-domain.com/api
```

## Endpoints

### 1. List All Passengers
**GET** `/passengers`

Returns a paginated list of all passengers.

**Response Example:**
```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "distributor": null,
      "fullname": "John Doe",
      "email": "john@example.com",
      "country_code": "+1",
      "contact": "1234567890",
      "address": "123 Main St",
      "city": "New York",
      "subpoint": null,
      "postal_code": "10001",
      "passenger_type": "regular",
      "tag": null,
      "user_image": null,
      "role": null,
      "verify": false,
      "status": true,
      "fcm_token": null,
      "is_first_booking": true,
      "created_at": "2026-02-16T11:53:21.000000Z",
      "updated_at": "2026-02-16T11:53:21.000000Z"
    }
  ],
  "per_page": 10,
  "total": 1
}
```

### 2. Create New Passenger
**POST** `/passengers`

Creates a new passenger record.

**Request Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Request Body:**
```json
{
  "fullname": "John Doe",
  "email": "john@example.com",
  "password": "SecurePass123",
  "country_code": "+1",
  "contact": "1234567890",
  "address": "123 Main St",
  "city": "New York",
  "postal_code": "10001",
  "passenger_type": "regular",
  "status": true,
  "verify": false
}
```

**Required Fields:**
- `fullname` (string, max 255 chars)
- `email` (valid email, unique)
- `password` (string, min 8 chars)

**Optional Fields:**
- `distributor` (string)
- `country_code` (string)
- `contact` (string)
- `address` (text)
- `city` (string)
- `subpoint` (string)
- `postal_code` (string)
- `passenger_type` (string)
- `tag` (string)
- `user_image` (image file: jpeg, png, jpg, gif, max 2MB)
- `role` (string)
- `otp_key` (string)
- `verify` (boolean)
- `status` (boolean)
- `fcm_token` (string)
- `is_first_booking` (boolean)

**Response:**
```json
{
  "message": "Passenger created successfully",
  "data": {
    "id": 1,
    "fullname": "John Doe",
    "email": "john@example.com",
    ...
  }
}
```

### 3. Get Single Passenger
**GET** `/passengers/{id}`

Retrieves a specific passenger by ID.

**Response:**
```json
{
  "id": 1,
  "distributor": null,
  "fullname": "John Doe",
  "email": "john@example.com",
  ...
}
```

### 4. Update Passenger
**PUT/PATCH** `/passengers/{id}`

Updates an existing passenger record.

**Request Body:** (same as create, but all fields are optional except `fullname` and `email`)

**Response:**
```json
{
  "message": "Passenger updated successfully",
  "data": {
    "id": 1,
    "fullname": "John Doe Updated",
    ...
  }
}
```

### 5. Delete Passenger
**DELETE** `/passengers/{id}`

Deletes a passenger record and associated files.

**Response:**
```json
{
  "message": "Passenger deleted successfully"
}
```

## Database Schema

The `passengers` table includes the following fields:

| Field | Type | Nullable | Default | Description |
|-------|------|----------|---------|-------------|
| id | integer | No | Auto | Primary key |
| distributor | string | Yes | null | Distributor info |
| fullname | string | No | - | Full name |
| email | string | No | - | Email (unique) |
| country_code | string | Yes | null | Country code |
| contact | string | Yes | null | Contact number |
| password | string | No | - | Hashed password |
| address | text | Yes | null | Address |
| city | string | Yes | null | City |
| subpoint | string | Yes | null | Subpoint |
| postal_code | string | Yes | null | Postal code |
| passenger_type | string | Yes | null | Passenger type |
| tag | string | Yes | null | Tag |
| user_image | string | Yes | null | Image path |
| role | string | Yes | null | Role |
| otp_key | string | Yes | null | OTP key |
| verify | boolean | No | false | Verification status |
| status | boolean | No | true | Active status |
| fcm_token | string | Yes | null | FCM token |
| is_first_booking | boolean | No | true | First booking flag |
| created_at | datetime | Yes | - | Creation timestamp |
| updated_at | datetime | Yes | - | Update timestamp |

## Security Features

- Passwords are automatically hashed using bcrypt
- Email addresses must be unique
- Password minimum length: 8 characters
- Sensitive fields (password, otp_key) are hidden in API responses
- Image uploads are validated for type and size

## Example Usage with cURL

```bash
# Create a passenger
curl -X POST http://localhost:8000/api/passengers \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "fullname": "Jane Smith",
    "email": "jane@example.com",
    "password": "SecurePass123",
    "city": "Los Angeles"
  }'

# List all passengers
curl -X GET http://localhost:8000/api/passengers \
  -H "Accept: application/json"

# Get specific passenger
curl -X GET http://localhost:8000/api/passengers/1 \
  -H "Accept: application/json"

# Update passenger
curl -X PUT http://localhost:8000/api/passengers/1 \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "fullname": "Jane Smith Updated",
    "email": "jane@example.com"
  }'

# Delete passenger
curl -X DELETE http://localhost:8000/api/passengers/1 \
  -H "Accept: application/json"
```

## Notes

- All API responses are in JSON format
- The password field is never returned in API responses for security
- When uploading images, use multipart/form-data encoding
- Images are stored in the `storage/app/public/passengers` directory
