# jquery.input-dropdown

===
Summary
### Installation ###
テキストボックスにドロップダウンをつける。
[Sample](https://jsfiddle.net/kohei_mizobata/mzantv30/122/)

### Usage ###

```html
<input id="input-sample">
```
```javascript
const userList = [
    { name: 'Alice', age: 18 },
    { name: 'Bob', age: 21 },
    { name: 'Mallory', age: 25 }
]

$('#input-sample').inputDropdown(userList, {
  formatter: user => {
    return `<li username=${user.name}>$user.name}(${user.age})</li>`
  },
  valueKey: 'username'
}
```

### Options ###
* formatter: function
* valueKey: 取得するデータのキー
* maxHeight: ドロップダウンの高さ

### License ###  
MIT
