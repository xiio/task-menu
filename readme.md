# Menu manager

## Table of Contents
- [How to submit the task](#how-to-submit-the-task)
- [Task description](#task-description)
- [Considerations](#considerations)
- [Routes](#routes)
- [Bonus points](#bonus-points)

## How to submit the task

Fork this repository and implement the logic. Make a pull request to the original repository once you complete the work. This will be eventually rejected, regardless of the correctness of the code.

## Task Description

- A Menu has a depth of **N** and maximum number of items per layer **M**. Consider **N** and **M** to be dynamic for bonus points.
- It should be possible to manage the menu by sending API requests.
- Do not implement a frontend for this task.
- Feel free to add comments or considerations when submitting the response at the end of the `README`.

## Considerations

Git history will be reviewed aswell as part of this task.

If you don't have time to implement a part of the system but you know how, try create the placeholder and write comments with the intended behaviour.


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
    "field": "value"
}
```


##### Bonus

```json
{
    "field": "value",
    "max_depth": 5,
    "max_children": 5
}
```


#### Output

```json
{
    "field": "value"
}
```


##### Bonus

```json
{
    "field": "value",
    "max_depth": 5,
    "max_children": 5
}
```


### `GET /menus/{menu}`

Get the menu.


#### Output

```json
{
    "field": "value"
}
```


##### Bonus

```json
{
    "field": "value",
    "max_depth": 5,
    "max_children": 5
}
```


### `PUT|PATCH /menus/{menu}`

Update the menu.


#### Input

```json
{
    "field": "value"
}
```


##### Bonus

```json
{
    "field": "value",
    "max_depth": 5,
    "max_children": 5
}
```


#### Output

```json
{
    "field": "value"
}
```


##### Bonus

```json
{
    "field": "value",
    "max_depth": 5,
    "max_children": 5
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
        "field": "value"
    },
    {
        "field": "value"
    }
]
```


##### Bonus

```json
[
    {
        "field": "value",
        "children": [
            {
                "field": "value",
                "children": []
            },
            {
                "field": "value"
            }
        ]
    },
    {
        "field": "value"
    }
]
```


#### Output

```json
[
    {
        "field": "value"
    },
    {
        "field": "value"
    }
]
```


##### Bonus

```json
[
    {
        "field": "value",
        "children": [
            {
                "field": "value",
                "children": []
            },
            {
                "field": "value"
            }
        ]
    },
    {
        "field": "value"
    }
]
```


### `GET /menus/{menu}/items`

Get all menu items.


#### Output

```json
[
    {
        "field": "value"
    },
    {
        "field": "value"
    }
]
```


##### Bonus

```json
[
    {
        "field": "value",
        "children": [
            {
                "field": "value",
                "children": []
            },
            {
                "field": "value"
            }
        ]
    },
    {
        "field": "value"
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
    "field": "value"
}
```


#### Output

```json
{
    "field": "value"
}
```


### `GET /items/{item}`

Get the item.


#### Output

```json
{
    "field": "value"
}
```


### `PUT|PATCH /items/{item}`

Update the item.


#### Input

```json
{
    "field": "value"
}
```


#### Output

```json
{
    "field": "value"
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
        "field": "value"
    },
    {
        "field": "value"
    }
]
```


##### Bonus

```json
[
    {
        "field": "value",
        "children": [
            {
                "field": "value",
                "children": []
            },
            {
                "field": "value"
            }
        ]
    },
    {
        "field": "value"
    }
]
```


#### Output

```json
[
    {
        "field": "value"
    },
    {
        "field": "value"
    }
]
```


##### Bonus

```json
[
    {
        "field": "value",
        "children": [
            {
                "field": "value",
                "children": []
            },
            {
                "field": "value"
            }
        ]
    },
    {
        "field": "value"
    }
]
```


### `GET /items/{item}/children`

Get all item's children.


#### Output

```json
[
    {
        "field": "value"
    },
    {
        "field": "value"
    }
]
```


##### Bonus

```json
[
    {
        "field": "value",
        "children": [
            {
                "field": "value",
                "children": []
            },
            {
                "field": "value"
            }
        ]
    },
    {
        "field": "value"
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
        "field": "value"
    },
    {
        "field": "value"
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
    "depth": 5
}
```


## Bonus points

* 10 vs 1.000.000 menu items - what would you do differently?
* Write documentation
* Use PhpCS | PhpCsFixer | PhpStan
* Use cache
* Use docker
* Implement tests


# TKsionek Notices
## Dirs
* app/Domain: Domain logic 
* app/Modules: App layer domain implementation

## Bonus points
* 10 vs 1.000.000 menu items - what would you do differently? - 
    - We can use queues to do async job for creating items.
    - Cache
    - We can use CQRS to separate write/read optimised storage. 
* Write documentation - i wrote phpdoc comments. I was trying to be verbose. 
* Use cache - cache is used only for MenuRepository. I used decorator pattern to wrap real repository with cacheRepository.
* Use docker - see docker-composer.yml
* Coding standard tools
    - PhpCsFixer: used
    - PhpCS: 
    - PhpStan: used
    - SonarLint: used

## CONSIDERATIONS
* I dont know we prefer to use uuid or auto increment id in mysql. In my opinion generated id's are more flexible. We can use it with async (queues) writes.
* I use Eloquent AC, but i prefer to use Doctrine. In my opinion ActiveRecord is AntiPattern. AC break for ex. SRP. I separate infrastructure layer from domain layer manually. In Doctrine we have native mechanism to keep entity as clean php object without inheritance. 
* I omit creating some helper methods (ex. to standardize json response). In controllers can be a bit redundant code. It's good practice to create dedicated controller for api responses with factory methods.
* I do some over engineering. I have separated layers (domain, infrastructure etc) to achieve more flexibility. It's possible to do this CRUD simpler.
* Items depth is counting from 0.
* I don't really know what is "layer". I assume that is a level of nesting but i'm not sure.
* I like to keep all thinks connected with module (Menu) in one place. But here i resign from reconfiguring Laravel to search for controllers in other place. If you want to know more please feel free to ask :)
* I've created RedisMenuRepository for cache handling. But i don't implement caching layer. It's just to show my idea.
* More unit tests needed. I just cover basic requirements.
 
## Security
- App is using MySql on root account. Create dedicated user with right permissions.
- Docker compose config is really basic.
