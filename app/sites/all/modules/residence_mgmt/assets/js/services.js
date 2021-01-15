// var urlRequest = "";
// $.ajax(urlRequest,
// {
//     dataType: 'json', // type of response data
//     success: function (response,status,xhr) {   // success callback function
//
//     },
//     error: function (jqXhr, textStatus, errorMessage) { // error callback
//         console.log('Error: ' + errorMessage);
//     }
// });

// var BASE_API_URL = "https://french-data.dev";

var BASE_API_URL = "http://api.silverpricing.fr";

function getDepartmentDetail( currentDepartment ) {
    cl(currentDepartment);
    var urlRequest = "/ajax/departement-info/" + currentDepartment.tid;

    $.ajax(urlRequest,
    {
        method: 'GET',
        dataType: 'json',
        success: function (response,status,xhr) {

            var depInfo = response;
            departmentInfo.classList.remove('d-none');
            var departementLink = "<a href=\"" + window.location.protocol + "//" + window.location.host + "/departement/" + currentDepartment.tid + "\">" + currentDepartment.name + " <i class='fas fa-link'></i>" + "</a>";

            departmentInfo.querySelector('.departement-name').innerHTML = departementLink;
            departmentInfo.querySelector('.department-link').innerHTML =  "<i class='fas fa-link'></i> " + currentDepartment.name;
            departmentInfo.querySelector('.department-link').href= window.location.protocol + "//" + window.location.host + "/departement/" + currentDepartment.tid+'-'+currentDepartment.name.replace(/ /gi,'');
            departmentInfo.querySelector('.dep-nbre-maisons').textContent = depInfo["Nbre de maisons"];
            departmentInfo.querySelector('.dep-tarif-min').textContent = depInfo["Tarif plus bas"] + " €";
            departmentInfo.querySelector('.dep-tarif-max').textContent = depInfo["Tarif plus haut"] + " €";
            departmentInfo.querySelector('.dep-tarif-moyen').textContent = depInfo["Tarif moyen"] + " €";
            departmentInfo.querySelector('.dep-tarif-median').textContent = depInfo["Tarif médian"] + " €";
            departmentInfo.querySelector('.dep-nbre-lits').textContent = depInfo["Nbre de lits"];
        },
        error: function (jqXhr, textStatus, errorMessage) {
            console.log('Error: ' + errorMessage);
        }
    });

}

function getGeoJsonOfCitiesByDepartment( departmentSelected, citySelected ) {

    var requestData = { "department" : departmentSelected, "cities": citySelected };

    console.log(requestData);

	  // var requestUrl = "/ajax/get-geojson-of-cities-by-department/" + departmentSelected + "/" + citySelected;
    var requestUrl = "/ajax/get-geojson-of-cities-by-department";

    $.ajax(requestUrl,
    {
        type: 'POST',
        dataType: 'json',
        data: requestData,
        success: function (response,status,xhr) {
            // var data = JSON.parse(response);
            var data = response;

            if( data.data_validation ) {
                $(".departement-wrapper .alert-devtools-error").removeClass('d-none');
            } else if( data.has_not_enough_balance ) {
                $(".departement-wrapper .alert-devtools").removeClass('d-none');
            } else {

              $(".devtools-summary .resultat-departement .resultat-departement-valeur").text(data.statistiques.resultatDepartement);
              $(".devtools-summary .resultat-prive .resultat-prive-valeur").text(data.statistiques.resultatPrive);
              $(".devtools-summary .resultat-associatif .resultat-associatif-valeur").text(data.statistiques.resultatAssociatif);
              $(".devtools-summary .resultat-public .resultat-public-valeur").text(data.statistiques.resultatPublic);

              var geoJsonResult = L.geoJSON(data, {
                    style: function(feature) {
                        if( feature.properties.residences.length > 0 ) {
                            var colors = ["#a5d7fd", "#66a4fd", "#4d95fb", "#0168fa", "#325a98"];
                            var sommeTarifResidences = 0;
                            for( var i = 0 ; i < feature.properties.residences.length ; i++  ) {
                                sommeTarifResidences += parseFloat(feature.properties.residences[i].field_tarif_chambre_simple_value);
                            }

                            var tarifMoyen = sommeTarifResidences / feature.properties.residences.length;

                            var tarifLevel = (tarifMoyen > 45) ? Math.floor(tarifMoyen / 45) : 1;

                            return {fillColor: colors[tarifLevel - 1], color: "#ffffff", fillOpacity: 0.95, strokeWidth: 1};
                        }
                        return {fillColor: "#b2bece", color: "#ffffff", fillOpacity: 0.95, strokeWidth: 1};
                    },
                    onEachFeature: onEachFeature
              }).addTo(map);

              map.fitBounds(geoJsonResult.getBounds());

            }

            $(".departement-wrapper #department-submit").html("Envoyer");
            $(".departement-wrapper #department-submit").removeAttr("disabled");
        },
        error: function (jqXhr, textStatus, errorMessage) {
            console.log('Error: ' + errorMessage);
            $(".departement-wrapper .alert-devtools-error").removeClass('d-none');
            $(".departement-wrapper #department-submit").html("Envoyer");
            $(".departement-wrapper #department-submit").removeAttr("disabled");
        }
    });

}

function getDVFByCitiesAndByYear( yearSelected, citiesSelected ) {

  var requestData = { "year" : yearSelected, "cities": citiesSelected };

  console.log(requestData);

  var requestUrl = BASE_API_URL + "/api/property_values/year-and-cities";

  $.ajax(requestUrl,
  {
      type: 'POST',
      dataType: 'json',
      data: requestData,
      success: function (response,status,xhr) {
          // var data = JSON.parse(response);
          var data = response;

          yeelderToolsTable.clear();
          for( i = 0 ; i < data.length ; i++) {
              yeelderToolsTable.row.add(data[i]);
          }
          yeelderToolsTable.draw();

          $("#dvf-form-wrapper #dvf-submit").html("Envoyer");
          $("#dvf-form-wrapper #dvf-submit").removeAttr("disabled");
      },
      error: function (jqXhr, textStatus, errorMessage) {
          console.log('Error: ' + errorMessage);
          // $(".departement-wrapper .alert-devtools").removeClass('d-none');
          $("#dvf-form-wrapper #dvf-submit").html("Envoyer");
          $("#dvf-form-wrapper #dvf-submit").removeAttr("disabled");
      }
  });

}

function getListOfCitiesByDepartment( departmentSelected ) {

    var requestUrl =  BASE_API_URL + "/api/cities/department/" + departmentSelected + "/list";

    $.ajax(requestUrl,
    {
        type: 'GET',
        dataType: 'json',
        success: function (response,status,xhr) {

            var cities = response.map(function(item) { return { "id":item.code, "text":item.nom }; });

            $('#city-autocomplete option').remove();

            $('#city-autocomplete').select2({
                data: cities
            });

        },
        error: function (jqXhr, textStatus, errorMessage) {
            console.log('Error: ' + errorMessage);

            $('#city-autocomplete option').remove();
        }
    });
}

function getListOfCitiesByDepartmentInDvf( departmentSelected ) {

  var requestUrl =  BASE_API_URL + "/api/cities/department/" + departmentSelected + "/list";

  $.ajax(requestUrl,
  {
      type: 'GET',
      dataType: 'json',
      success: function (response,status,xhr) {

          var cities = response.map(function(item) { return { "id":item.code, "text":item.nom }; });

          $('#city-dvf-autocomplete option').remove();

          $('#city-dvf-autocomplete').select2({
              data: cities
          });

      },
      error: function (jqXhr, textStatus, errorMessage) {
          console.log('Error: ' + errorMessage);

          $('#city-dvf-autocomplete option').remove();
      }
  });
}

function getDvfOfCommune( codeCommune, popupContentUpdated, layer ) {

    var requestUrl = "/ajax/get-dvf-of-commune/" + codeCommune;

    $.ajax(requestUrl,
    {
        type: 'GET',
        dataType: 'json',
        success: function (response,status,xhr) {

            var data = Object.entries(response);

            data.forEach(function(e, i) {
                popupContentUpdated += "<br />" + "<strong>" + e[0] + "</strong> : " + (e[1].valeur_fonciere/e[1].surface_terrain).toFixed(2) + " € / m²";
            });

            popupContentUpdated += "</p>";

            console.log(popupContentUpdated);

            layer.getPopup().setContent(popupContentUpdated);
            layer.getPopup().update();

        },
        error: function (jqXhr, textStatus, errorMessage) {
            console.log('Error: ' + errorMessage);
        }
    });

}

function getAllPropertyValuesOfCommune( codeCommune ) {

  var requestUrl = BASE_API_URL + "/api/property_values/commune/" + codeCommune;

  $.ajax(requestUrl,
  {
      type: 'GET',
      dataType: 'json',
      success: function (response,status,xhr) {

          console.log(response);

          var data = response;

          yeelderToolsTable.clear();
          for( i = 0 ; i < data.length ; i++) {
              yeelderToolsTable.row.add(data[i]);
          }

          yeelderToolsTable.draw();

      },
      error: function (jqXhr, textStatus, errorMessage) {
          console.log('Error: ' + errorMessage);
      }
  });

}

function getGeoCodingSilverex( adresse ) {

    var urlRequest = "/ajax/geocoding-silverex";

    $.ajax( urlRequest,
    {
        type: 'POST',
        dataType: 'json',
        data : { adresse: adresse },
        success: function (data,status,xhr) {

            if( data.length > 0 ) {
              document.querySelector("#latitude").value = data[0].lat;
              document.querySelector("#longitude").value = data[0].lon;

              $("#search-form").submit();
            }

        },
        error: function (jqXhr, textStatus, errorMessage) {
            console.log('Error: ' + errorMessage);
        }
    });

}

function addTMHMaquette( residenceNid, maquetteModifiee ) {

    var urlRequest =  "/ajax/add-tmh-maquette/" + residenceNid;

    $.ajax(urlRequest,
    {
        method: "POST",
        data: { maquette: JSON.stringify(maquetteModifiee) },
        success: function (response,status,xhr) {
            console.log(response);
            console.log("Thank you for saving my data");
            nbreMaquettes( residenceNid );
        },
        error: function (jqXhr, textStatus, errorMessage) {
            console.error(errorMessage);
            nbreMaquettes( residenceNid );
        }
    });

}

function addMaquetteToFavoris( dataNid, residenceNid ) {

    var urlRequest =  "/ajax/add-maquette-to-favoris/" + dataNid;

    console.log(residenceNid);
    console.log(dataNid);

    $.ajax(urlRequest,
    {
        method: "POST",
        data: { field_favoris : 1 },
        success: function (response,status,xhr) {
            // console.log("Succès! ajouter cet maquette à mes favoris.");
            reloadHistoriquesMaquettes( residenceNid );

        },
        error: function (jqXhr, textStatus, errorMessage) {
            console.log('Error: ' + errorMessage);
        }
    });

}

function nbreMaquettes( residenceNid ) {

    var urlRequest =  "/ajax/nbre-maquettes/" + residenceNid;

    $.ajax(urlRequest,
    {
        method: "GET",
        data: {},
        success: function (response,status,xhr) {
            console.log("response : " + response);
            document.querySelector("#btn-historiques-maquettes span.badge").textContent = response;
            return response;
        },
        error: function (jqXhr, textStatus, errorMessage) {
            console.log('Error: ' + errorMessage);
            return 0;
        }
    });

}

function reloadHistoriquesMaquettes( residenceId ) {

    var urlRequest = "/ajax/historique-maquettes/" + residenceId;
    var $tableRoot = $('#table-historiques-maquettes tbody');

    $.ajax(urlRequest,
    {
        method: "POST",
        dataType: 'json',
        data: {},
        success: function (response,status,xhr) {
            $tableRoot.html("");
            var historiques = response;
            historiques.forEach(function(m, i) {

                var tmhDate = new Date(m.created * 1000);
                $tableRoot.append("<tr></tr>");
                var $historiqueRow = $tableRoot.find('tr').last();
                if( m.field_favoris.und[0].value == 0 ) {
                  $historiqueRow.append('<td><a href="#" data-favoris="0" data-nid="' + m.nid + '" onClick="toggleFavoris(this)"><i class="far fa-star"></i></a></td>');
                } else {
                  $historiqueRow.append('<td><a href="#" data-favoris="1" data-nid="' + m.nid + '" onClick="toggleFavoris(this)"><i class="fas fa-star"></i></a></td>');
                }
                $historiqueRow.append('<td> ' + tmhDate.getDate() + "/" + (tmhDate.getMonth() + 1) + "/" + tmhDate.getFullYear() + ' </td>');
                $historiqueRow.append('<td>' + m.name + '</td>');
                $historiqueRow.append('<td>' + m.field_tmh.und[0].value + ' €' + '</td>');

                $historiqueRow.append('<td>' +
                    '<span class="badge badge-success d-block">' + m.field_cs_entree_de_gamme_lits.und[0].value + ' <i class="fa fa-bed" aria-hidden="true"></i></span>' +
                    '<span class="badge badge-primary d-block mg-t-2">' + m.field_cs_entree_de_gamme_tarif.und[0].value + ' <i class="fa fa-euro-sign" aria-hidden="true"></i></span>'
                + '</td>');
                $historiqueRow.append('<td>' +
                    '<span class="badge badge-success d-block">' + m.field_cs_standard_lits.und[0].value + ' <i class="fa fa-bed" aria-hidden="true"></i></span>' +
                    '<span class="badge badge-primary d-block mg-t-2">' + m.field_cs_standard_tarif.und[0].value + ' <i class="fa fa-euro-sign" aria-hidden="true"></i></span>'
                + '</td>');
                $historiqueRow.append('<td>' +
                    '<span class="badge badge-success d-block">' + m.field_cs_luxe_lits.und[0].value + ' <i class="fa fa-bed" aria-hidden="true"></i></span>' +
                    '<span class="badge badge-primary d-block mg-t-2">' + m.field_cs_luxe_tarif.und[0].value + ' <i class="fa fa-euro-sign" aria-hidden="true"></i></span>'
                + '</td>');
                $historiqueRow.append('<td>' +
                    '<span class="badge badge-success d-block">' + m.field_cs_superieur_lits.und[0].value + ' <i class="fa fa-bed" aria-hidden="true"></i></span>' +
                    '<span class="badge badge-primary d-block mg-t-2">' + m.field_cs_superieur_tarif.und[0].value + ' <i class="fa fa-euro-sign" aria-hidden="true"></i></span>'
                + '</td>');
                $historiqueRow.append('<td>' +
                    '<span class="badge badge-success d-block">' + m.field_cs_alzheimer_lits.und[0].value + ' <i class="fa fa-bed" aria-hidden="true"></i></span>' +
                    '<span class="badge badge-primary d-block mg-t-2">' + m.field_cs_alzheimer_tarif.und[0].value + ' <i class="fa fa-euro-sign" aria-hidden="true"></i></span>'
                + '</td>');
                $historiqueRow.append('<td>' +
                    '<span class="badge badge-success d-block">' + m.field_cs_aide_sociale_lits.und[0].value + ' <i class="fa fa-bed" aria-hidden="true"></i></span>' +
                    '<span class="badge badge-primary d-block mg-t-2">' + m.field_cs_aide_sociale_tarif.und[0].value + ' <i class="fa fa-euro-sign" aria-hidden="true"></i></span>'
                + '</td>');
                $historiqueRow.append('<td>' +
                    '<span class="badge badge-success d-block">' + m.field_cd_standard_lits.und[0].value + ' <i class="fa fa-bed" aria-hidden="true"></i></span>' +
                    '<span class="badge badge-primary d-block mg-t-2">' + m.field_cd_standard_tarif.und[0].value + ' <i class="fa fa-euro-sign" aria-hidden="true"></i></span>'
                + '</td>');
                $historiqueRow.append('<td>' +
                    '<span class="badge badge-success d-block">' + m.field_cd_aide_sociale_lits.und[0].value + ' <i class="fa fa-bed" aria-hidden="true"></i></span>' +
                    '<span class="badge badge-primary d-block mg-t-2">' + m.field_cd_aide_sociale_tarif.und[0].value + ' <i class="fa fa-euro-sign" aria-hidden="true"></i></span>'
                + '</td>');
                $historiqueRow.append('<td class="maquette-action">' +
                    '<button type="button" class="btn btn-primary btn-icon" data-mid="' + m.nid + '"><i class="fa fa-trash"></i></button>'
                + '</td>');

            });

            console.log("Thank you ! Loading complete of content");

            $tableRoot.find("td.maquette-action .btn").on('click', function(event) {
              event.preventDefault();
              var maquetteId = $(this).attr('data-mid');
              $.ajax("/ajax/remove-tmh-maquette/" + maquetteId,
              {
                  method: "POST",
                  dataType: "JSON",
                  data: {},
                  success: function (response,status,xhr) {
                      console.log("DATA MID : " + maquetteId);
                      console.log(response.field_residence.und[0].target_id);
                      reloadHistoriquesMaquettes(response.field_residence.und[0].target_id);
                  },
                  error: function (jqXhr, textStatus, errorMessage) {
                      console.log('Error: ' + errorMessage);
                  }
              });

            });

        },
        error: function (jqXhr, textStatus, errorMessage) {
            console.log('Error: ' + errorMessage);
        }
    });

}


function getEvolutionMenusuelleDesTarifs( residenceNid ) {
    var urlRequest = "/ajax/get-evolution-menusuelle-des-tarifs/" + residenceNid;
    $.ajax(urlRequest,
    {
        dataType: 'json', // type of response data
        success: function (response,status,xhr) {   // success callback function
            var data = response;
            cl('getEvolutionMenusuelleDesTarifs',data);//#bonobo-rouge
            $('#situation-concurrentielle .sc-residence').text(data.dataResidence[data.dataResidence.length - 1] + "€");
            $('#situation-concurrentielle .sc-departement').text(data.dataDepartement[data.dataDepartement.length - 1] + "€");
            $('#situation-concurrentielle .sc-concurrence-direct').text(data.dataResidencesConcurrents[data.dataResidencesConcurrents.length - 1] + "€");

            evolutionChart = new Chart(document.getElementById('evolution-line-chart').getContext('2d'), {
                type: 'bar',
                data: {
                    datasets: [
                        {
                            type: 'line',
                            label: 'Résidence',
                            backgroundColor: '#e84572',
                            borderColor: '#e84572',
                            fill: false,
                            data: data.dataResidence,
                        },
                        {
                            label: 'Département',
                            backgroundColor: '#72e0b1',
                            borderColor: '#72e0b1',
                            fill: false,
                            data: data.dataDepartement,
                        },
                        {
                            label: '10 Concurrents les + proches',
                            backgroundColor: '#65a3f8',
                            borderColor: '#65a3f8',
                            fill: false,
                            data: data.dataResidencesConcurrents,
                        },
                    ],
                    labels: data.xAxe
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'center'
                    },
                    scales: {
                        yAxes: [{
                            position: 'left',
                            ticks: {
                                beginAtZero:true,
                                fontSize: 10,
                                fontColor: '#182b49',
                            }
                        }],
                        xAxes: [{
                            barPercentage: 1,
                            ticks: {autoSkip:true, beginAtZero:true, fontSize: 12, maxRotation: 90, minRotation: 90,fontColor: '#182b49',}
                        }]
                    }
                }
            });
        },
        error: function (jqXhr, textStatus, errorMessage) { // error callback
            cl('Error: ' + errorMessage);
        }
    });

}
