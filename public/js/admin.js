function valideCommentaire(id, etat){
  if ( confirm( "valider ce commentaire?" ) ) {
    alert("il faut ajouter la fonction mais on verra la semaine prochaine");

    //window.location ("http://{{ base}}admin/moderate-comment/"+id+"/"+etat)
  } else {
    return;
  }
}

function supprimeCommentaire(id){
  if ( confirm( "valider ce commentaire?" ) ) {
    alert("il faut ajouter la fonction mais on verra la semaine prochaine");
  } else {
    return;
  }  
}