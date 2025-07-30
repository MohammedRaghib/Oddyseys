# Odysseys Costing

Odysseys Costing is a comprehensive trip management and costing application designed to help users organize and calculate the costs associated with trips. The application provides functionality for managing parks, hotels, visitor details, and associated fees, and allows users to preview detailed cost breakdowns.

---

## **Features**

### **1. Trip Costing Interface**
- Enter trip details such as:
  - Parks and associated hotels.
  - Visitor breakdowns (e.g., adults, children, infants).
  - Costs for car hire, flights, and extras.
- Dynamically add or remove rows to manage multiple entries.
- Automatically calculates total costs, including taxes.

### **2. Park and Hotel Management**
- Manage parks and their associated hotels with ease.
- Add, edit, or list existing hotels along with rate details for different seasons.
- Search functionality to quickly find parks or hotels.

### **3. Cost Preview**
- View a detailed breakdown of costs for trips:
  - Conservancy fees, hotel costs, concession fees, and more.
  - Special fees (if applicable).
  - Subtotals for each visitor type and overall costs.
- Displays additional details such as profit and discount percentages.

### **4. Dynamic Backend Integration**
- Uses a MySQL database for managing parks, hotels, and their rates.
- Processes trip costing dynamically by fetching and calculating data based on user input.

---

## **File Overviews**

### **index.php**
- **Purpose**: Main interface for trip costing.
- **Key Features**:
  - Allows users to input trip details.
  - Calculates total costs and provides a preview option.

### **preview.php**
- **Purpose**: Displays a detailed breakdown of trip costs.
- **Key Features**:
  - Dynamically renders cost details based on JSON data passed via the URL.
  - Includes sections for park breakdowns, visitor costs, and overall totals.

### **get_cost.php**
- **Purpose**: Calculates the total cost of a trip, including various fees and extras.
- **Key Features**:
  - Processes POST requests containing trip details.
  - Calculates costs dynamically, including:
    - Park fees based on visitor type and date.
    - Hotel and concession fees per night.
    - Car hire and special fees.
  - Fetches rates and details from a SQLite database.
  - Outputs a JSON summary of the costs.

### **get_parks.php**
- **Purpose**: Provides information about parks and associated hotels.
- **Key Features**:
  - Handles both GET and POST requests:
    - GET: Fetches a list of parks and related hotels or detailed hotel information.
    - POST: Retrieves hotels associated with a selected park.
  - Outputs JSON responses with relevant data.

### **add_hotel.php**
- **Purpose**: Web interface for managing park hotels.
- **Key Features**:
  - Add or update hotel details and rates.
  - Supports dynamic addition and removal of rate rows for different seasons.
  - Fetches park and hotel data for dropdowns and lists.

---

## **Technologies Used**
- **Front-End**:
  - HTML, CSS, JavaScript
  - Responsive design for a clean user interface.
  - Dynamic rendering powered by JavaScript.
- **Back-End**:
  - PHP for handling database interactions and processing requests.
  - MySQL database for storing parks, hotels, and rate details.

---
