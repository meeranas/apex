# Customer-Issuer Relationship Implementation

## Overview
This document outlines the implementation of the customer-issuer relationship where each issuer has their own customers, ensuring proper data isolation and access control.

## Key Changes Made

### 1. Database Schema Updates
- **Added `issuer_id` to customers table**: Foreign key relationship to issuers
- **Migration**: `add_issuer_id_to_customers_table.php`
- **Constraint**: Cascade delete when issuer is deleted

### 2. Model Updates

#### Customer Model:
- **Added `issuer_id` to fillable fields**
- **Added `issuer()` relationship**: BelongsTo Issuer
- **Updated relationships**: All customer relationships now respect issuer ownership

#### Issuer Model:
- **Added `customers()` relationship**: HasMany Customer
- **Added `getAllViewableCustomers()` method**: Returns customers from issuers they can view

### 3. Access Control Rules

#### Admin Access:
- **Full Access**: Can see all customers from all issuers
- **Management**: Can assign customers to any issuer
- **Creation**: Can create customers for any issuer

#### Issuer Access:
- **Own Customers**: Always see their own customers
- **Assigned Customers**: Can see customers from issuers they have access to
- **Creation**: Can only create customers for themselves (auto-assigned)
- **Editing**: Can only edit their own customers

### 4. Resource Updates

#### CustomerResource:
- **Added issuer selection field** in forms
- **Auto-assignment**: Issuers automatically get their own issuer_id
- **Access control**: Query scoping based on issuer permissions
- **Table display**: Shows issuer information
- **Filtering**: Can filter by issuer

#### InvoiceResource & TransactionResource:
- **Customer dropdown filtering**: Only shows customers from accessible issuers
- **Query modification**: `modifyQueryUsing()` filters customers by issuer access
- **Display enhancement**: Shows customer account number in dropdown

### 5. Form Behavior

#### For Admins:
- **Issuer Selection**: Dropdown to choose any issuer
- **Customer Selection**: Can select from all customers
- **Full Control**: Can manage all relationships

#### For Issuers:
- **Auto-assignment**: Issuer ID automatically set to their own
- **Limited Customer Selection**: Only see their own customers and those from accessible issuers
- **Disabled Fields**: Cannot change issuer assignment

### 6. Data Isolation

#### Customer Data:
- **Issuer-specific**: Each customer belongs to one issuer
- **Access Control**: Issuers only see customers they have access to
- **Cascade Deletion**: When issuer is deleted, their customers are also deleted

#### Invoice/Transaction Data:
- **Customer-based Filtering**: Only show invoices/transactions for accessible customers
- **Consistent Access**: Same access rules apply across all resources

## Implementation Details

### Database Migration:
```php
Schema::table('customers', function (Blueprint $table) {
    $table->foreignId('issuer_id')->nullable()->after('id')
          ->constrained('issuers')->onDelete('cascade');
});
```

### Model Relationships:
```php
// Customer Model
public function issuer(): BelongsTo
{
    return $this->belongsTo(Issuer::class);
}

// Issuer Model
public function customers(): HasMany
{
    return $this->hasMany(Customer::class);
}
```

### Access Control Query:
```php
public static function getEloquentQuery(): Builder
{
    $user = Auth::user();
    
    if ($user->hasRole('admin')) {
        return parent::getEloquentQuery(); // See all customers
    }
    
    if ($user->hasRole('issuer') && $user->issuer) {
        $issuer = $user->issuer;
        $viewableIssuerIds = $issuer->getAllViewableIssuers()->pluck('id');
        return parent::getEloquentQuery()->whereIn('issuer_id', $viewableIssuerIds);
    }
    
    return parent::getEloquentQuery()->whereRaw('1 = 0'); // No access
}
```

### Customer Dropdown Filtering:
```php
Forms\Components\Select::make('customer_id')
    ->relationship('customer', 'customer_name')
    ->modifyQueryUsing(function (Builder $query) {
        $user = Auth::user();
        
        if ($user && $user->hasRole('admin')) {
            return $query; // Admin sees all
        }
        
        if ($user && $user->hasRole('issuer') && $user->issuer) {
            $issuer = $user->issuer;
            $viewableIssuerIds = $issuer->getAllViewableIssuers()->pluck('id');
            return $query->whereIn('issuer_id', $viewableIssuerIds);
        }
        
        return $query->whereRaw('1 = 0'); // No access
    })
```

## Benefits

### 1. Data Isolation
- **Clear Ownership**: Each customer belongs to a specific issuer
- **Access Control**: Issuers only see their own customers
- **Security**: Prevents unauthorized access to customer data

### 2. Scalability
- **Multi-tenant**: Each issuer operates independently
- **Performance**: Queries are filtered at the database level
- **Maintenance**: Easy to manage issuer-specific data

### 3. User Experience
- **Relevant Data**: Users only see customers they can work with
- **Intuitive Interface**: Clear relationship between issuers and customers
- **Consistent Behavior**: Same access rules across all resources

### 4. Business Logic
- **Territory Management**: Each issuer manages their own customers
- **Cross-issuer Access**: Controlled sharing of customer data
- **Audit Trail**: Clear ownership of all customer records

## Usage Examples

### Creating a Customer as an Issuer:
1. Log in as an issuer
2. Navigate to Customers → Create
3. Fill in customer details
4. Issuer ID is automatically set to their own
5. Save customer

### Creating an Invoice as an Issuer:
1. Log in as an issuer
2. Navigate to Invoices → Create
3. Select customer from dropdown (only shows their customers)
4. Issuer ID is automatically set to their own
5. Fill in invoice details and save

### Admin Managing Cross-issuer Access:
1. Log in as admin
2. Navigate to Issuers → Edit
3. Use "Can View Other Issuers" multiselect
4. Select which issuers this issuer can view
5. Save changes

## Conclusion

The customer-issuer relationship implementation provides:
- **Complete data isolation** between issuers
- **Flexible access control** for cross-issuer data sharing
- **Intuitive user interface** that respects user roles
- **Scalable architecture** for multi-issuer operations
- **Consistent security** across all resources

This implementation ensures that each issuer has their own customer base while allowing controlled sharing of data when needed, providing a robust foundation for multi-user business operations.
