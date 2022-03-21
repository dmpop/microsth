function popup(text, css=``) {
  // ポップアップの生成
  const p = document.createElement("div");
  p.innerHTML = text;
  p.className = "popup";
  p.id = popup_reset('popup-temporary');
  // ポップアップを追加
  document.getElementsByTagName('body')[0].appendChild(p);
  // ポップアップ削除までの800msの猶予
  setTimeout(function(){
    // 1000msかけてポップアップを削除
    popup_fire(p.id, 10, (Array.from({length: 100}, (_, i) => i*0.01).reverse()))
  }, 800);
};

// ポップアップのIDを再帰的に確保
function popup_reset(id) {
  if(document.getElementById(id) != null){
    return popup_reset(id + '-altenative');
  } else {
    return id;
  }
}

// 再帰的にポップアップを薄くして最終的に削除
function popup_fire(id,dt,X) {
  if(document.getElementById(id) != null){
    if(X.length){
      const p = document.getElementById(id);
      p.style.opacity = X.shift();
      setTimeout(function(){
        popup_fire(id,dt,X)
      }, dt);
    } else {
      document.getElementById(id).remove();
    }
  }
};