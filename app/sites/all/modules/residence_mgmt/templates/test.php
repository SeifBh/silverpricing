<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Dashboard : Residences Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/sites/all/modules/residence_mgmt/assets/css/c3.min.css">
    <link rel="stylesheet" href="/sites/all/modules/residence_mgmt/assets/css/main.css" />
</head>
<body>

    <div class="container">

        <section class="section-2">
            <div class="row">
                <div class="col-md-12">
                  <div id="departement_chart_div"></div>
                </div>
            </div>
        </section>

    </div>

    <script src="https://d3js.org/d3.v5.min.js" charset="utf-8"></script>
    <script src="/sites/all/modules/residence_mgmt/assets/js/c3.min.js"></script>
    <script src="/sites/all/modules/residence_mgmt/assets/js/main.js"></script>
    <script type="text/javascript" >
      var chart = c3.generate({
          bindto: '#departement_chart_div',
          data: {
            x: 'x',
            columns: [
              ['x', 'CHEVALINE', 'NICE', 'VENDRES', 'LU', 'AGE', 'CAYENE', 'CHEVALNE', 'NCE', 'VENRES', 'LUZ', 'AGECAYNNE'],
              ['ville', 30, 200, 100, 400, 150, 250, 30, 200, 100, 400, 150, 250],
              ['prix', 50, 20, 10, 40, 15, 25, 50, 20, 10, 40, 15, 25]
            ],
            axes: {
              ville: 'y',
              prix: 'y2'
            },
            types: {
              ville: 'bar'
            }
          },
          axis: {
            x: {
              type: 'category',
                tick: {
                  rotate: 75,
                  multiline: false
              }
            },
            y: {
              label: {
                text: 'Ville',
                position: 'outer-middle'
              }
            },
            y2: {
              show: true,
              label: {
                text: 'Prix',
                position: 'outer-middle'
              }
            }
          }
      });
    </script>
</body>
</html>