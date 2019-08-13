# Menu manager


## Table of Contents
- [Task description](#task-description)
- [Routes](#routes)
- [Bonus](#bonus)


## Task Description

Fork or Download this repository and write a program to manage a menu.

Site menu has depth of **N** and maximum number of items per layer **M**. Consider **N** and **M** to be dynamic for bonus points.

It should be possible to use the program by sending API requests.


### Example menu

* Home
    * Home sub1
        * Home sub sub
            * [N] 
    * Home sub2
    * [M]
* About
* [M]


## Routes


### `POST /menus`

Create a menu.


#### Input

```json
{
    field: "value"
}
```


##### Bonus

```json
{
    field: "value",
    max_depth: 5,
    max_children: 5
}
```


#### Output

```json
{
    field: "value"
}
```


##### Bonus

```json
{
    field: "value",
    max_depth: 5,
    max_children: 5
}
```


### `GET /menus/{menu}`

Get the menu.


#### Output

```json
{
    field: "value"
}
```


##### Bonus

```json
{
    field: "value",
    max_depth: 5,
    max_children: 5
}
```


### `PUT|PATCH /menus/{menu}`

Update the menu.


#### Input

```json
{
    field: "value"
}
```


##### Bonus

```json
{
    field: "value",
    max_depth: 5,
    max_children: 5
}
```


#### Output

```json
{
    field: "value"
}
```


##### Bonus

```json
{
    field: "value",
    max_depth: 5,
    max_children: 5
}
```


### `DELETE /menus/{menu}`

Delete the menu.


### `POST /menus/{menu}/items`

Create menu items.


#### Input

```json
[
    {
        field: "value"
    },
    {
        field: "value"
    }
]
```


##### Bonus

```json
[
    {
        field: "value",
        children: [
            {
                field: "value",
                children: []
            },
            {
                field: "value"
            }
        ]
    },
    {
        field: "value"
    }
]
```


#### Output

```json
[
    {
        field: "value"
    },
    {
        field: "value"
    }
]
```


##### Bonus

```json
[
    {
        field: "value",
        children: [
            {
                field: "value",
                children: []
            },
            {
                field: "value"
            }
        ]
    },
    {
        field: "value"
    }
]
```


### `GET /menus/{menu}/items`

Get all menu items.


#### Output

```json
[
    {
        field: "value"
    },
    {
        field: "value"
    }
]
```


##### Bonus

```json
[
    {
        field: "value",
        children: [
            {
                field: "value",
                children: []
            },
            {
                field: "value"
            }
        ]
    },
    {
        field: "value"
    }
]
```


### `DELETE /menus/{menu}/items`

Remove all menu items.


### `POST /items`

Create an item.


#### Input

```json
{
    field: "value"
}
```


#### Output

```json
{
    field: "value"
}
```


### `GET /items/{item}`

Get the item.


#### Output

```json
{
    field: "value"
}
```


### `PUT|PATCH /items/{item}`

Update the item.


#### Input

```json
{
    field: "value"
}
```


#### Output

```json
{
    field: "value"
}
```


### `DELETE /items/{item}`

Delete the item.


### `POST /items/{item}/children`

Create item's children.


#### Input

```json
[
    {
        field: "value"
    },
    {
        field: "value"
    }
]
```


##### Bonus

```json
[
    {
        field: "value",
        children: [
            {
                field: "value",
                children: []
            },
            {
                field: "value"
            }
        ]
    },
    {
        field: "value"
    }
]
```


#### Output

```json
[
    {
        field: "value"
    },
    {
        field: "value"
    }
]
```


##### Bonus

```json
[
    {
        field: "value",
        children: [
            {
                field: "value",
                children: []
            },
            {
                field: "value"
            }
        ]
    },
    {
        field: "value"
    }
]
```


### `GET /items/{item}/children`

Get all item's children.


#### Output

```json
[
    {
        field: "value"
    },
    {
        field: "value"
    }
]
```


##### Bonus

```json
[
    {
        field: "value",
        children: [
            {
                field: "value",
                children: []
            },
            {
                field: "value"
            }
        ]
    },
    {
        field: "value"
    }
]
```


### `DELETE /items/{item}/children`

Remove all children.


### `GET /menus/{menu}/layers/{layer}`

Get all menu items in a layer.


#### Output

```json
[
    {
        field: "value"
    },
    {
        field: "value"
    }
]
```


### `DELETE /menus/{menu}/layers/{layer}`

Remove a layer and relink `layer + 1` with `layer - 1`, to avoid dangling data.


### `GET /menus/{menu}/depth`


#### Output

Get depth of menu.

```json
{
    depth: 5
}
```


## Bonus

* 10 vs 1.000.000 menu items - what would you do differently?
* Write documentation
* Use PhpCS | PhpCsFixer | PhpStan
* Use cache
* Use data structures
* Use docker
