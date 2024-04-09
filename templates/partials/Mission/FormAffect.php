<div class="mt-3 mb-5 mx-2">
                            <label for="hideouts" class=" col-4 d-inline attributName"> Les planques de la mission :</label>
                            <select multiple="multiple" name="hideouts[]" id="hideouts" class="col-8 d-inline attribueValue formInput" >
                                <optgroup label="planque">
                                    <option value=null > Aucune </option>
                                    <?php foreach ($hideouts as $hideout) { ?> 
                                        <option value=<?php echo($hideout['id'])?> ><?php echo(htmlspecialchars($hideout['type_hide']." : ".$hideout['address'] . ", " . $hideout['zipcode'] . ", " . $hideout['city'] . ", " . $hideout['country_name']))?> </option>
                                    <?php } ?>
                                </optgroup>
                            </select>
                            <?php if (!empty($errors['hideouts'])){?>
                                <div class="alert alert-danger"><?php echo($errors['hideouts']) ?></div>
                            <?php } ?>
                        </div>