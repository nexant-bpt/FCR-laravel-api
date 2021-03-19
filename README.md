### Controller method convention 
- The **index** method will be to grab a list of items
- Use **store** when ever you create an item
- Use **show** when ever you want to display just one item (example: get client by id)
- Use **update** when ever you want to update an item in the database
- Use **destroy** to delete an item from the database
- If you need to update one property on a item in the database you can name the method **updateItemName** and have it be a patch http method

##### Example
```php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function index()
    {
        // query goes here
    }

    public function store()
    {
        // query goes here

    }

    public function update()
    {
        // query goes here

    }
    public function show()
    {
        // query goes here
    }

    public function destroy()
    {
        // query goes here
    }
}


```

### Status codes to return when CREATING, READING, UPDATING, or DELETING
- use **200** for **show** or **index**
- use **201** when ever using **store**
- use **202** when using **destroy**
- use **200** for **update** if it's a post
- use **204**  if it's a patch